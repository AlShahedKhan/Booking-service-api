<?php

namespace App\Repositories;

use App\Interfaces\ServiceRepositoryInterface;
use App\Models\Service;

class ServiceRepository implements ServiceRepositoryInterface
{
    public function all() { return Service::where('status', 'active')->get(); }
    public function create(array $data) { return Service::create($data); }
    public function update($id, array $data) {
        $service = Service::findOrFail($id);
        $service->update($data);
        return $service;
    }
    public function delete($id) { return Service::destroy($id); }
    public function find($id) { return Service::findOrFail($id); }
}
