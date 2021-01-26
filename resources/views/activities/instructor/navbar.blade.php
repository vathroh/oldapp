<nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color:transparent;">
    <div class="d-flex">
        @foreach(Auth::User()->ActivityParticipant->where('activity_id', $id) as $role)
        <a href="/kegiatan/{{ strtolower($role->role) }}/absensi/{{ $activity->id }}">
            <button class="btn btn-primary">
                {{ $role->role }}
            </button>
            @endforeach
        </a>
    </div>
    <a class="nav-link" href="/kegiatan/pemandu/absensi/{{ $activity->id }}">Daftar Hadir</a>
    <a class="nav-link" href="/kegiatan/pemandu/jadwal/{{ $activity->id }}">Jadwal</a>
    <a class="nav-link" href="/kegiatan/pemandu/materi/{{ $activity->id }}">Materi</a>
    <a class="nav-link" href="/kegiatan/pemandu/sertifikat/{{ $activity->id }}">Sertifikat</a>
</nav>