<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProgramController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index()
    {
        $this->authorize("viewAny", Program::class);
        return Inertia::render("Programs/Index", [
            "programs" => Program::withoutTrashed()->paginate(10),
        ]);
    }

    public function create()
    {
        $this->authorize("create", Program::class);
        return "Can Create";
    }

    public function show(Program $program)
    {
        $this->authorize("view", $program);
        return "Can Show";
    }

    public function edit(Program $program)
    {
        $this->authorize("update", $program);
        return "Can Edit";
    }

    public function update(Request $request, Program $program)
    {
        $this->authorize("update", $program);
        return "Can Update";
    }

    public function destroy(Program $program)
    {
        $this->authorize("delete", $program);
        return "Can Delete";
    }

    public function restore(int $id)
    {
        $program = Program::withoutTrashed()->find($id);
        $this->authorize("restore", $program);
        return "Can Restore";
    }


}
