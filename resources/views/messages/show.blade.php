@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <a href="{{ route('messages.index') }}" class="btn btn-link text-success text-decoration-none mb-4 p-0">
                <i class="fas fa-arrow-left me-2"></i> Orqaga qaytish
            </a>

            <div class="glass-morphism p-4 p-md-5">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h2 class="text-white fw-bold mb-1">{{ $message->subject ?? 'Mavzusiz xabar' }}</h2>
                        <small class="text-muted">Yuborildi: {{ $message->created_at->format('d.m.Y H:i') }}</small>
                    </div>
                    @if($message->is_from_admin)
                        <span class="badge bg-danger bg-opacity-25 text-danger rounded-pill px-3 py-2">Administratsiya</span>
                    @endif
                </div>

                <hr class="border-light border-opacity-10 my-4">

                <div class="message-body text-white-50 lh-lg" style="font-size: 1.1rem; white-space: pre-wrap;">
                    {{ $message->body }}
                </div>

                <div class="mt-5 pt-4 border-top border-light border-opacity-10">
                    <p class="text-muted small">Hurmat bilan,<br>KalomUz jamoasi</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
