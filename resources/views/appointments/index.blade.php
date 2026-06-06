@extends('layouts.app')
@section('title', 'My Appointments')
@section('page-title', 'My Appointments')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-calendar-plus-fill me-2 text-primary"></i>My Appointments</span>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addAppointmentModal">
            <i class="bi bi-plus-lg me-1"></i>Add Appointment
        </button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Client</th>
                        <th>Service</th>
                        <th>Date & Time</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appt)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-600">{{ $appt->title }}</td>
                        <td>
                            <div>{{ $appt->client_name }}</div>
                            @if($appt->client_phone)
                            <div class="text-muted small"><i class="bi bi-telephone me-1"></i>{{ $appt->client_phone }}</div>
                            @endif
                        </td>
                        <td><span class="badge bg-info text-dark">{{ $appt->service }}</span></td>
                        <td class="small">
                            <i class="bi bi-clock me-1 text-muted"></i>
                            {{ $appt->appointment_date->format('M d, Y h:i A') }}
                        </td>
                        <td class="small text-muted">{{ $appt->duration }} mins</td>
                        <td><span class="badge bg-{{ $appt->status_badge }}">{{ $appt->status }}</span></td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-warning me-1 btn-edit"
                                data-id="{{ $appt->id }}"
                                data-title="{{ $appt->title }}"
                                data-client_name="{{ $appt->client_name }}"
                                data-client_email="{{ $appt->client_email }}"
                                data-client_phone="{{ $appt->client_phone }}"
                                data-service="{{ $appt->service }}"
                                data-appointment_date="{{ $appt->appointment_date->format('Y-m-d\TH:i') }}"
                                data-duration="{{ $appt->duration }}"
                                data-status="{{ $appt->status }}"
                                data-notes="{{ $appt->notes }}"
                                data-bs-toggle="modal" data-bs-target="#editAppointmentModal">
                                <i class="bi bi-pencil-fill"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger btn-delete"
                                data-id="{{ $appt->id }}" data-title="{{ $appt->title }}"
                                data-bs-toggle="modal" data-bs-target="#deleteAppointmentModal">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-5">
                            <i class="bi bi-calendar-x fs-2 d-block mb-2"></i>No appointments yet. Add one!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($appointments->hasPages())<div class="p-3">{{ $appointments->links() }}</div>@endif
    </div>
</div>

<div class="modal fade" id="addAppointmentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="{{ route('appointments.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-calendar-plus-fill me-2"></i>Add New Appointment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-600">Appointment Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" placeholder="e.g. Hair Cut" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Service <span class="text-danger">*</span></label>
                            <input type="text" name="service" class="form-control" placeholder="e.g. Haircut, Massage, Consultation" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Client Name <span class="text-danger">*</span></label>
                            <input type="text" name="client_name" class="form-control" placeholder="Client full name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Client Email</label>
                            <input type="email" name="client_email" class="form-control" placeholder="client@email.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Client Phone</label>
                            <input type="text" name="client_phone" class="form-control" placeholder="09xx-xxx-xxxx">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Appointment Date & Time <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="appointment_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Duration (minutes) <span class="text-danger">*</span></label>
                            <select name="duration" class="form-select" required>
                                <option value="15">15 minutes</option>
                                <option value="30" selected>30 minutes</option>
                                <option value="45">45 minutes</option>
                                <option value="60">1 hour</option>
                                <option value="90">1.5 hours</option>
                                <option value="120">2 hours</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-600">Notes</label>
                            <textarea name="notes" class="form-control" rows="2" placeholder="Optional notes..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Save Appointment</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="editAppointmentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form method="POST" id="editAppointmentForm">
            @csrf @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil-fill me-2"></i>Edit Appointment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-600">Appointment Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="edit_title" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Service <span class="text-danger">*</span></label>
                            <input type="text" name="service" id="edit_service" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Client Name <span class="text-danger">*</span></label>
                            <input type="text" name="client_name" id="edit_client_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Client Email</label>
                            <input type="email" name="client_email" id="edit_client_email" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Client Phone</label>
                            <input type="text" name="client_phone" id="edit_client_phone" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Date & Time <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="appointment_date" id="edit_appointment_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Duration (minutes)</label>
                            <select name="duration" id="edit_duration" class="form-select">
                                <option value="15">15 minutes</option>
                                <option value="30">30 minutes</option>
                                <option value="45">45 minutes</option>
                                <option value="60">1 hour</option>
                                <option value="90">1.5 hours</option>
                                <option value="120">2 hours</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-600">Status</label>
                            <select name="status" id="edit_status" class="form-select">
                                <option value="Scheduled">Scheduled</option>
                                <option value="Completed">Completed</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-600">Notes</label>
                            <textarea name="notes" id="edit_notes" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning"><i class="bi bi-save me-1"></i>Update</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="deleteAppointmentModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <form method="POST" id="deleteAppointmentForm">
            @csrf @method('DELETE')
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-danger"><i class="bi bi-trash-fill me-2"></i>Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <i class="bi bi-exclamation-triangle-fill text-warning fs-1"></i>
                    <p class="mt-2">Delete <strong id="delete_title"></strong>?</p>
                    <p class="text-muted small">This cannot be undone.</p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash me-1"></i>Delete</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('edit_title').value            = this.dataset.title;
            document.getElementById('edit_service').value          = this.dataset.service;
            document.getElementById('edit_client_name').value      = this.dataset.client_name;
            document.getElementById('edit_client_email').value     = this.dataset.client_email;
            document.getElementById('edit_client_phone').value     = this.dataset.client_phone;
            document.getElementById('edit_appointment_date').value = this.dataset.appointment_date;
            document.getElementById('edit_duration').value         = this.dataset.duration;
            document.getElementById('edit_status').value           = this.dataset.status;
            document.getElementById('edit_notes').value            = this.dataset.notes;
            document.getElementById('editAppointmentForm').action  = `/appointments/${this.dataset.id}`;
        });
    });
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('delete_title').textContent = this.dataset.title;
            document.getElementById('deleteAppointmentForm').action = `/appointments/${this.dataset.id}`;
        });
    });
</script>
@endpush
