<?php

namespace App\Http\Controllers;

use App\Models\Membre;
use App\Models\Post;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function getall()
    {
        
        
            $posts = Post::with('Membre')->get();
            $membre = Membre::all();
            
    
            return view('post', [
                //'films' c'est la variable utilisé dans le view et $films c'est la variable de la fonction 
                'posts' => $posts,
                'membres' => $membre,
                
    
            ]);
        
    }

   

    public function create(Request $request)
    {
        
        
       
        
        $posts = Post::with('Membre')->get();
        $membre = Membre::all();
        $posts = Post::create([
            'titre' => $request->titre,
            'contenu' => $request->contenu,
            'ddp' => NOW(),
            'censure' => $request->censure,
            
            'membres' => $membre,
     

        ]);

      
        
        $posts->save();
       

        return redirect()->route('post')->with('success', 'Post ajouté');
    }

    public function accueil()
    {
        $posts = Post::with('Membre')->get();
        $membre = Membre::all();
       
       
        return view('welcome', [

            
            'posts' => $posts,
             'membres' => $membre,
            



        ]);
}

public function delete($id)
{
    $posts = Post::where('id', '=', $id);
    $posts->delete();
    return redirect()->route('post');
}
public function crud()
{
    $posts = Post::with('Membre')->get();
    $membre = Membre::all();
   
   
    return view('crud', [

        
        'posts' => $posts,
         'membres' => $membre,
        



    ]);
}
public function creates(Request $request)
{
  
    $path = Storage::disk('public')->put('img', $request->file('images'));
    $posts = Post::with('Membre')->get();
    $membre = Membre::all();
    $posts = Post::create([
        'titre' => $request->titre,
        'contenu' => $request->contenu,
        'ddp' => NOW(),
        'censure' => $request->censure,
        'photo' => $path,
        'membres' => $membre,
 

    ]);

  dd($path);
    
    $posts->save();
   

    return redirect()->route('crud')->with('success', 'Post ajouté');



    
}
}
