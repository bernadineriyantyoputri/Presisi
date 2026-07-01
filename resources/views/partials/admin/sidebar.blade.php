<div class="bg-dark text-white p-3" style="width:250px; min-height:100vh;">

    <h4 class="border-bottom pb-2">ADMIN</h4>

    <a href="{{ route('admin') }}" class="text-white d-block mb-2">Verifikasi Akun</a>
    <a href="#" class="text-white d-block mb-2">Dashboard Admin</a>
    <a href="#" class="text-white d-block mb-2">Laporan</a>

    <hr>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="btn btn-danger w-100">Logout</button>
    </form>

</div>