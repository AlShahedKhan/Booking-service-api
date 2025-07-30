<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequest;
use App\Repositories\Interfaces\ServiceRepositoryInterface;

class ServiceController extends Controller
{
    protected $serviceRepo;
    public function __construct(ServiceRepositoryInterface $serviceRepo) {
        $this->serviceRepo = $serviceRepo;
    }

    public function index() { return response()->json($this->serviceRepo->all()); }
    public function store(ServiceRequest $request) {
        return response()->json($this->serviceRepo->create($request->validated()), 201);
    }
    public function update(ServiceRequest $request, $id) {
        return response()->json($this->serviceRepo->update($id, $request->validated()));
    }
    public function destroy($id) {
        $this->serviceRepo->delete($id);
        return response()->json(null, 204);
    }
}
