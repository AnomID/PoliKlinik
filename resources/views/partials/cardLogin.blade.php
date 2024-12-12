<div class="col-md-6 mb-4">
    <div class="card h-100 border-3 shadow">
        <div class="card-body d-flex align-items-center">
            <div>
                {{-- Icon --}}
                @if(isset($iconPath))
                    <img src="{{ asset($iconPath) }}" alt="Icon" style="width: 70px; height: 70px; margin-bottom: 30px;">
                @else
                    <i class="{{ $iconClass ?? 'bi bi-person-circle' }}" style="font-size: 2.5rem; color: #007bff;"></i>
                @endif
                <h5 class="card-title fw-bold">{{ $title }}</h5>
                <p class="card-text text-muted">{{ $description }}</p>
                <a href="{{ $link }}" class="btn btn-main">{{ $linkText }}</a>
            </div>
        </div>
    </div>
</div>
