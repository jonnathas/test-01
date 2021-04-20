<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(){

        return responder()->success(Product::get())->respond();
    }
    public function store(Request $request){

        if(Product::create($request->all())){
            return responder()->success()->respond(201,['message' => 'Produto criado com sucesso.']);
        }
    }
    public function update($id,Request $request){

        $product = Product::find($id);

        $product->update($request->all());
        $product->save();

        return responder()->success()->respond(200,['message' => 'Produto atualizado com sucesso!']);
    }
    public function destroy($id){
        
        $product = Product::find($id);
        
        $product->delete();

        return responder()->success()->respond(200,['message' => 'Produto deletado com sucesso']);
    }
}
