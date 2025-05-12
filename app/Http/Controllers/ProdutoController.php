<?php
namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController 
{
    public function index()
    {
        return view('produtos.index');
    }

    public function list($termo = null)
    {
        try {
            $query = Produto::query();

            if ($termo) {
                $query->where('nome', 'like', "%{$termo}%");
            }

            $produtos = $query->orderBy('id', 'desc')->get();

            return response()->json([
                'status' => 'success',
                'data'   => $produtos,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Erro ao buscar produtos.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }


    public function create()
    {
        return view('produtos.create');
    }

    public function store(Request $request)
    {
        try {
            $request->merge([
                'preco'      => str_replace(',', '.', str_replace('.', '', $request->preco)),
                'quantidade' => str_replace('.', '', $request->quantidade),
            ]);

            $validated = $request->validate([
                'nome'       => 'required|string',
                'preco'      => 'required|numeric|min:0',
                'quantidade' => 'required|integer|min:0',
                'descricao'  => 'nullable|string',
            ]);

            Produto::create($validated);

            return response()->json(['message' => 'Produto criado com sucesso.'], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao criar o produto.', 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $produto = Produto::find($id);

        if (! $produto) {
            return redirect()->route('produtos.index')->with('error', 'Produto não encontrado.');
        }

        return view('produtos.show', compact('produto'));
    }

    public function edit($id)
    {
        $produto = Produto::find($id);

        if (! $produto) {
            return redirect()->route('produtos.index')
                ->with('error', 'Produto não encontrado.');
        }

        return view('produtos.edit', compact('produto'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->merge([
                'preco'      => str_replace(',', '.', str_replace('.', '', $request->preco)),
                'quantidade' => str_replace('.', '', $request->quantidade),
            ]);

            $validated = $request->validate([
                'nome'       => 'required|string',
                'preco'      => 'required|numeric|min:0',
                'quantidade' => 'required|integer|min:0',
                'descricao'  => 'nullable|string',
            ]);

            $produto = Produto::findOrFail($id);
            $produto->update($validated);

            return response()->json(['message' => 'Produto atualizado com sucesso.']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao atualizar o produto.', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $produto = Produto::find($id);

            if (! $produto) {
                return response()->json([
                    'message' => 'Produto não encontrado.',
                ], 404);
            }

            $produto->delete();

            return response()->json([
                'message' => 'Produto excluído com sucesso.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao excluir o produto.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

}
