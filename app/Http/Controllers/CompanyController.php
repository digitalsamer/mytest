<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompanyController extends Controller
{
    
    public function index(Request $request) {
        return response()->json($request->user()->companies);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'industry' => 'nullable|string'
        ]);

        $company = $request->user()->companies()->create($request->all());

        return response()->json($company, 201);
    }

    public function update(Request $request, Company $company) {
        $this->authorizeOwnership($request, $company);

        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'industry' => 'nullable|string'
        ]);

        $company->update($request->all());
        return response()->json($company);
    }

    public function destroy(Request $request, Company $company) {
        $this->authorizeOwnership($request, $company);
        $company->delete();
        return response()->json(['message' => 'Company deleted']);
    }

    public function setActive(Request $request, Company $company) {
        $this->authorizeOwnership($request, $company);

        $user = $request->user();
        $user->active_company_id = $company->id;
        $user->save();

        return response()->json(['message' => 'Active company set successfully']);
    }

    private function authorizeOwnership(Request $request, Company $company) {
        if ($company->user_id !== $request->user()->id) {
            abort(403, 'Unauthorized');
        }
    }
    
}
