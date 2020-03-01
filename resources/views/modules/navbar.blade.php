<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">
            {{config('diisquare.title')}}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse float-lg-right" id="navbarNav">
            <ul class="navbar-nav ml-md-auto"> {{--bootstrap4 align right is shit --}}
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="http://jupyter.yp51md.club">Jupyter</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">施工中</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">施工中</a>
                </li>
            </ul>
        </div>
    </nav>
</div>

