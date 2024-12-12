<div class="col-md-6 mb-4">
    <div class="card h-100 border-3 shadow">
        <div class="card-body d-flex flex-column align-items-center text-center">
            {{-- Icon --}}
            @if(isset($iconPath))
                <img src="{{ asset($iconPath) }}" alt="{{ $title }} Icon" class="mb-4" style="width: 80px; height: 80px;">
            @else
                <i class="{{ $iconClass ?? 'bi bi-person-circle' }}" style="font-size: 3rem; color: #007bff;"></i>
            @endif
            {{-- Title --}}
            <h5 class="card-title fw-bold mb-3">{{ $title }}</h5>
            {{-- Description --}}
            <p class="card-text text-muted mb-4">{{ $description }}</p>
            {{-- Action Button --}}
            <a href="{{ $link }}" class="btn btn-primary">{{ $linkText }}</a>
        </div>
    </div>
</div>
