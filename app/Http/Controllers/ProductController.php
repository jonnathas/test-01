<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(){

        return responder()->success(Product::get())->respond();
    }
    public function store(Request $request){

        if($product = Product::create($request->all())){

            if($request->file->isValid()){
                $request->file->storeAs('product',$product->id);
            }

            return responder()->success($product)->respond(200,['message' => 'Produto criado com sucesso.']);
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
    public function getImage($id){
        
        $product = Product::find($id);

        if (!Storage::disk('local')->exists('product/'.$product->id)) {
            return responder()->error()->respond(404,['message' => 'Imagem não encontrada!']);
        }

        $local_path = config('filesystems.disks.local.root') . DIRECTORY_SEPARATOR . 'product/' . $product->id;

        return response()->file($local_path);
        
    }
}
