<?php
// app/Http/Controllers/Admin/CountryController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CountrieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $countries = Country::query()
            ->when($search, function ($query, $search) {
                return $query->search($search);
            })
            ->orderBy('name', 'asc')
            ->paginate(10);

        return view('admin.countrie.index', compact('countries', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.countrie.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:countries,name',
            'description' => 'nullable|string|max:1000',
        ], [
            'name.required' => 'Le nom du pays est obligatoire.',
            'name.unique' => 'Ce pays existe déjà.',
            'name.max' => 'Le nom ne peut pas dépasser 255 caractères.',
            'description.max' => 'La description ne peut pas dépasser 1000 caractères.',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        Country::create($validated);

        return redirect()->route('admin.countries.index')
            ->with('success', 'Le pays a été créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Country $country)
    {
        return view('admin.countries.show', compact('country'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Country $country)
    {
        return view('admin.countrie.edit', compact('country'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Country $country)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:countries,name,' . $country->id,
            'description' => 'nullable|string|max:1000',
        ], [
            'name.required' => 'Le nom du pays est obligatoire.',
            'name.unique' => 'Ce pays existe déjà.',
            'name.max' => 'Le nom ne peut pas dépasser 255 caractères.',
            'description.max' => 'La description ne peut pas dépasser 1000 caractères.',
        ]);

        $country->update($validated);

        return redirect()->route('admin.countries.index')
            ->with('success', 'Le pays a été modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Country $country)
    {
        try {
            $country->delete();
            
            return redirect()->route('admin.countries.index')
                ->with('success', 'Le pays a été supprimé avec succès.');
        } catch (\Exception $e) {
            return redirect()->route('admin.countries.index')
                ->with('error', 'Impossible de supprimer ce pays. Il est peut-être utilisé ailleurs.');
        }
    }

    /**
     * Bulk delete countries.
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'countries' => 'required|array',
            'countries.*' => 'exists:countries,id'
        ]);

        try {
            Country::whereIn('id', $request->countries)->delete();
            
            return redirect()->route('admin.countries.index')
                ->with('success', count($request->countries) . ' pays ont été supprimés avec succès.');
        } catch (\Exception $e) {
            return redirect()->route('admin.countries.index')
                ->with('error', 'Erreur lors de la suppression des pays sélectionnés.');
        }
    }
}