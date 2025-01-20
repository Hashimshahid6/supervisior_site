@extends('layouts.master')
@section('title', 'Paypal Settings')
@section('page-title', 'Paypal Settings')
@section('content')
@include('components.flash_messages')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="text-center mb-4">
                    <button id="sandboxBtn" class="btn btn-primary">Sandbox</button>
                    <button id="liveBtn" class="btn btn-secondary">Live</button>
                </div>
                <form id="paypalSettingsForm" action="{{ route('paypal_settings.update', $paypalSettings[0]->id) }}"
                    method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="mode" id="mode" value="{{ $paypalSettings[0]->mode ?? '' }}">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="endpoint" class="form-label">Endpoint</label>
                                <input type="text" class="form-control" id="endpoint" name="endpoint"
                                    value="{{ $paypalSettings[0]->endpoint ?? '' }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="client_id" class="form-label">Client ID</label>
                                <input type="text" class="form-control" id="client_id" name="client_id"
                                    value="{{ $paypalSettings[0]->client_id ?? '' }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="client_secret" class="form-label">Client Secret</label>
                                <input type="text" class="form-control" id="client_secret" name="client_secret"
                                    value="{{ $paypalSettings[0]->client_secret ?? '' }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="payment_status" name="status" required>
                                    <option value="Active" {{ $paypalSettings[0]->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="Inactive" {{ $paypalSettings[0]->status == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 text-end">
                            <button type="submit" class="btn btn-success">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    document.getElementById('sandboxBtn').addEventListener('click', function() {
        var settings = @json($paypalSettings);
        var sandboxSettings = settings.find(setting => setting.mode === 'sandbox');
        if (sandboxSettings) {
            document.getElementById('endpoint').value = sandboxSettings.endpoint;
            document.getElementById('client_id').value = sandboxSettings.client_id;
            document.getElementById('client_secret').value = sandboxSettings.client_secret;
            document.getElementById('mode').value = sandboxSettings.mode;
            document.getElementById('payment_status').value = sandboxSettings.status;
        } else {
            alert('Sandbox settings not found.');
        }
    });

    document.getElementById('liveBtn').addEventListener('click', function() {
        var settings = @json($paypalSettings);
        var liveSettings = settings.find(setting => setting.mode === 'live');
        if (liveSettings) {
            document.getElementById('endpoint').value = liveSettings.endpoint;
            document.getElementById('client_id').value = liveSettings.client_id;
            document.getElementById('client_secret').value = liveSettings.client_secret;
            document.getElementById('mode').value = liveSettings.mode;
            document.getElementById('payment_status').value = liveSettings.status;
        } else {
            alert('Live settings not found.');
        }
    });
</script>
@endsection