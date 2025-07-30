<?php
namespace App\Repositories;

use App\Models\Blog;

class BlogRepository implements BlogRepositoryInterface
{
    public function all()
    {
        return Blog::all();
    }

    public function find($id)
    {
        return Blog::find($id);
    }

    public function create(array $data)
    {
        return Blog::create($data);
    }

    public function update($id, array $data)
    {
        $blog = Blog::find($id);
        if ($blog) {
            $blog->update($data);
        }
        return $blog;
    }

    public function delete($id)
    {
        $blog = Blog::find($id);
        if ($blog) {
            $blog->delete();
        }
        return $blog;
    }
}
