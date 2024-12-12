 <div
      class="modal fade"
      id="logoutModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button
              class="close"
              type="button"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            Select "Logout" below if you are ready to end your current session.
          </div>
          <div class="modal-footer">
            <button
              class="btn btn-secondary"
              type="button"
              data-dismiss="modal"
            >
              Cancel
            </button>
                    <!-- Admin Links -->
                    @if(session('user_role') === 'admin')
                        <!-- Add more admin-specific links here -->
                        <a class="btn btn-primary"  href="{{ route('logout.admin') }}">Logout</></a>
                    @endif

                    <!-- Dokter Links -->
                    @if(session('dokter_id'))
                        <!-- Add more dokter-specific links here -->
                        <a class="btn btn-primary"  href="{{ route('logout.dokter') }}">Logout</></a>
                    @endif

                    <!-- Pasien Links -->
                    @if(session('pasien_id'))
                        <!-- Add more pasien-specific links here -->
                        <a class="btn btn-primary"  href="{{ route('logout.pasien') }}">Logout</></a>
                    @endif
          </div>
        </div>
      </div>
    </div>
