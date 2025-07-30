<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequest;
use App\Repositories\Interfaces\ServiceRepositoryInterface;
use App\Helpers\ApiResponse;

class ServiceController extends Controller
{
    protected $serviceRepo;
    public function __construct(ServiceRepositoryInterface $serviceRepo)
    {
        $this->serviceRepo = $serviceRepo;
    }

    public function index() {
        $services = $this->serviceRepo->all();
        return ApiResponse::success($services, 'Services fetched successfully.');
    }
    public function store(ServiceRequest $request) {
        $service = $this->serviceRepo->create($request->validated());
        return ApiResponse::success($service, 'Service created successfully.', 201);
    }
    public function update(ServiceRequest $request, $id) {
        $service = $this->serviceRepo->update($id, $request->validated());
        return ApiResponse::success($service, 'Service updated successfully.');
    }
    public function destroy($id) {
        $this->serviceRepo->delete($id);
        return ApiResponse::success(null, 'Service deleted successfully.', 204);
    }
}
