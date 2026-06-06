<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::where('user_id', Auth::id())->latest()->paginate(10);
        return view('appointments.index', compact('appointments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'client_name'      => 'required|string|max:255',
            'client_email'     => 'nullable|email',
            'client_phone'     => 'nullable|string|max:20',
            'service'          => 'required|string|max:255',
            'appointment_date' => 'required|date|after:now',
            'duration'         => 'required|integer|min:15',
            'notes'            => 'nullable|string',
        ]);

        Appointment::create([
            'user_id'          => Auth::id(),
            'title'            => $request->title,
            'client_name'      => $request->client_name,
            'client_email'     => $request->client_email,
            'client_phone'     => $request->client_phone,
            'service'          => $request->service,
            'appointment_date' => $request->appointment_date,
            'duration'         => $request->duration,
            'status'           => 'Scheduled',
            'notes'            => $request->notes,
        ]);

        return redirect()->route('appointments.index')
            ->with('toast_success', 'Appointment "' . $request->title . '" added successfully!');
    }

    public function edit(Appointment $appointment)
    {
        $this->authorizeOwner($appointment);
        return response()->json($appointment);
    }

    public function update(Request $request, Appointment $appointment)
    {
        $this->authorizeOwner($appointment);

        $request->validate([
            'title'            => 'required|string|max:255',
            'client_name'      => 'required|string|max:255',
            'client_email'     => 'nullable|email',
            'client_phone'     => 'nullable|string|max:20',
            'service'          => 'required|string|max:255',
            'appointment_date' => 'required|date',
            'duration'         => 'required|integer|min:15',
            'status'           => 'required|in:Scheduled,Completed,Cancelled',
            'notes'            => 'nullable|string',
        ]);

        $appointment->update($request->only(
            'title', 'client_name', 'client_email', 'client_phone',
            'service', 'appointment_date', 'duration', 'status', 'notes'
        ));

        return redirect()->route('appointments.index')
            ->with('toast_success', 'Appointment "' . $appointment->title . '" updated successfully!');
    }

    public function destroy(Appointment $appointment)
    {
        $this->authorizeOwner($appointment);
        $title = $appointment->title;
        $appointment->delete();
        return redirect()->route('appointments.index')
            ->with('toast_success', 'Appointment "' . $title . '" deleted successfully!');
    }

    private function authorizeOwner(Appointment $appointment)
    {
        if ($appointment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
