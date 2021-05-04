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
    <a class="nav-link" href="/kegiatan/peserta/absensi/{{ $activity->id }}">Daftar Hadir</a>
    <!-- <a class="nav-link" href="/activity/{{ $activity->category->id }}/{{ $activity->id }}">Evaluasi</a> -->
    <a class="nav-link" href="/kegiatan/peserta/evaluasi/{{ $activity->id }}">Evaluasi</a>
    <a class="nav-link" href="/kegiatan/peserta/jadwal/{{ $activity->id }}">Jadwal</a>
    <a class="nav-link" href="/kegiatan/peserta/materi/{{ $activity->id }}">Materi</a>
    @if($activity-> certificate)
    <a class="nav-link" href="/kegiatan/peserta/sertifikat/{{ $activity->id }}">Sertifikat</a>
    @endif
</nav>
