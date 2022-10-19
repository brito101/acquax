<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Image;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::user()->hasPermissionTo('Listar Posts')) {
            abort(403, 'Acesso não autorizado');
        }
        $posts = Post::orderBy('created_at', 'desc')->paginate();
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('Criar Posts')) {
            abort(403, 'Acesso não autorizado');
        }
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        if (!Auth::user()->hasPermissionTo('Criar Posts')) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();
        $data['editor'] = auth()->user()->id;

        $checkTitle = Post::where('title', $data['title'])->count();
        if ($checkTitle > 0) {
            $data['title'] =  $data['title'] . '-' . $checkTitle;
        }

        $data['slug'] = Str::slug($data['title']);

        if ($request->hasFile('cover') && $request->file('cover')->isValid()) {
            $name = Str::slug(mb_substr($data['title'], 0, 200)) . "-" . time();
            $extension = $request->cover->extension();
            $nameFile = "{$name}.{$extension}";
            $data['cover'] = $nameFile;
            $destinationPath = storage_path() . '/app/public/posts';
            $img = Image::make($request->cover);
            $img->resize(1200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->crop(1200, 630)->save($destinationPath . '/' . $nameFile);

            if (!$img)
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Falha ao fazer o upload da imagem');
        }


        if ($request->content) {
            $content = $request->content;
            $dom = new \DOMDocument();
            $dom->encoding = 'utf-8';
            $dom->loadHTML(utf8_decode($content), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOERROR | LIBXML_NOWARNING);
            $imageFile = $dom->getElementsByTagName('img');

            foreach ($imageFile as $item => $image) {
                $img = $image->getAttribute('src');
                if (filter_var($img, FILTER_VALIDATE_URL) == false) {
                    list($type, $img) = explode(';', $img);
                    list(, $img) = explode(',', $img);
                    $imageData = base64_decode($img);
                    $image_name =  Str::slug($request->title) . '-' . time() . $item . '.png';
                    $path = storage_path() . '/app/public/posts/' . $image_name;
                    file_put_contents($path, $imageData);
                    $image->removeAttribute('src');
                    $image->removeAttribute('data-filename');
                    $image->setAttribute('alt', $request->title);
                    $image->setAttribute('src', url('storage/posts/' . $image_name));
                }
            }

            $content = $dom->saveHTML();
            $data['content'] = $content;
        }

        $post = Post::create($data);

        if ($post->save()) {
            return redirect()
                ->route('admin.posts.index')
                ->with('success', 'Cadastro realizado!');
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Erro ao cadastrar!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Posts')) {
            abort(403, 'Acesso não autorizado');
        }

        $post = Post::where('id', $id)->first();

        if (empty($post->id)) {
            abort(403, 'Acesso não autorizado');
        }

        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {

        if (!Auth::user()->hasPermissionTo('Editar Posts')) {
            abort(403, 'Acesso não autorizado');
        }

        $post = Post::where('id', $id)->first();

        if (empty($post->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();

        $data['editor'] = auth()->user()->id;

        $checkTitle = Post::where('title', $data['title'])->where('id', '!=', $id)->count();
        if ($checkTitle > 0) {
            $data['title'] =  $data['title'] . '-' . $checkTitle;
        }

        $data['slug'] = Str::slug($data['title']);


        if ($request->hasFile('cover') && $request->file('cover')->isValid()) {
            $imagePath = storage_path() . '/app/public/posts/' . $post->cover;
            if (File::isFile($imagePath)) {
                unlink($imagePath);
            }

            $name = Str::slug(mb_substr($data['title'], 0, 200)) . "-" . time();
            $extension = $request->cover->extension();
            $nameFile = "{$name}.{$extension}";
            $data['cover'] = $nameFile;
            $destinationPath = storage_path() . '/app/public/posts';
            $img = Image::make($request->cover);
            $img->resize(1200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->crop(1200, 630)->save($destinationPath . '/' . $nameFile);

            if (!$img)
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Falha ao fazer o upload da imagem');
        }

        if ($request->content) {
            $content = $request->content;
            $dom = new \DOMDocument();
            $dom->encoding = 'utf-8';
            $dom->loadHTML(utf8_decode($content), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOERROR | LIBXML_NOWARNING);
            $imageFile = $dom->getElementsByTagName('img');

            foreach ($imageFile as $item => $image) {
                $img = $image->getAttribute('src');
                if (filter_var($img, FILTER_VALIDATE_URL) == false) {
                    list($type, $img) = explode(';', $img);
                    list(, $img) = explode(',', $img);
                    $imageData = base64_decode($img);
                    $image_name =  Str::slug($request->title) . '-' . time() . $item . '.png';
                    $path = storage_path() . '/app/public/posts/' . $image_name;
                    file_put_contents($path, $imageData);
                    $image->removeAttribute('src');
                    $image->removeAttribute('data-filename');
                    $image->setAttribute('alt', $request->title);
                    $image->setAttribute('src', url('storage/posts/' . $image_name));
                }
            }

            $content = $dom->saveHTML();
            $data['content'] = $content;
        }

        if ($post->update($data)) {
            return redirect()
                ->route('admin.posts.index')
                ->with('success', 'Atualização realizada!');
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Erro ao atualizar!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        if (!Auth::user()->hasPermissionTo('Excluir Posts')) {
            abort(403, 'Acesso não autorizado');
        }

        $post = Post::where('id', $id)->first();

        if (empty($post->id)) {
            abort(403, 'Acesso não autorizado');
        }

        if ($post->delete()) {
            $imagePathCover = storage_path() . '/app/public/posts/' . $post->cover;
            if (File::isFile($imagePathCover)) {
                unlink($imagePathCover);
                $post->cover = null;
                $post->update();
            }

            return redirect()
                ->route('admin.posts.index')
                ->with('success', 'Exclusão realizada!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Erro ao excluir!');
        }
    }
}
