  <!-- App Bottom Menu -->
  <div class="appBottomMenu">
      <a href="/dashboard" class="item {{ request()->is('dashboard') ? 'active' : '' }}">
          <div class="col">
              <ion-icon name="home-outline"></ion-icon>
              <strong>HOME</strong>
          </div>
      </a>
      <a href="/presensi/historis" class="item {{ request()->is('presensi/historis') ? 'active' : '' }}">
          <div class="col">
              <ion-icon name="calendar-outline" role="img" class="md hydrated"
                  aria-label="calendar outline"></ion-icon>
              <strong>HISTORI</strong>
          </div>
      </a>
      @if (Auth::guard('karyawan')->user()->status_jamkerja == '1')
          <a href="/presensi/null/create" class="item {{ request()->is('presensi/create') ? 'active' : '' }}">
              <div class="col">
                  <div class="action-button large">
                      <ion-icon name="camera" role="img" class="md hydrated" aria-label="add outline"></ion-icon>
                  </div>
              </div>
          </a>
      @else
          <a href="/presensi/pilihjamkerja" class="item {{ request()->is('presensi/create') ? 'active' : '' }}">
              <div class="col">
                  <div class="action-button large">
                      <ion-icon name="camera" role="img" class="md hydrated" aria-label="add outline"></ion-icon>
                  </div>
              </div>
          </a>
      @endif
      <a href="/presensi/dataijin" class="item {{ request()->is('presensi/dataijin') ? 'active' : '' }}">
          <div class="col">
              <ion-icon name="document-text-outline" role="img" class="md hydrated"
                  aria-label="document text outline"></ion-icon>
              <strong>IZIN</strong>
          </div>
      </a>
      </a>
      <a href="/editprofil" class="item {{ request()->is('editprofil') ? 'active' : '' }}">
          <div class="col">
              <ion-icon name="people-outline" role="img" class="md hydrated" aria-label="people outline"></ion-icon>
              <strong>PROFIL</strong>
          </div>
      </a>
  </div>
  <!-- * App Bottom Menu -->
