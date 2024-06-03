<div class="col-12 mt-3">

    @php
        isset($team->banner_path) ?
            $bannerPath = asset('storage/' . $team->banner_path)
            : $bannerPath = asset('img/synthetic_grass.png');

        isset($team->logo_path) ?
            $logoPath = asset('storage/' . $team->logo_path)
            : $logoPath = asset('img/dragon.png');
    @endphp

    <div class="card card-widget widget-user">
        <div class="widget-user-header text-white" style="background: url('{{ $bannerPath }}') center center; background-size: 100%">

        </div>
        <div class="widget-user-image">
            <img class="img-circle" src="{{ $logoPath }}" alt="User Avatar">
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-sm-12 border-bottom less-height">
                    <div class="description-block">
                        <h5 class="description-header">{{ $team->name }}</h5>
                    </div>
                </div>

                <div class="col-sm-6 border-right">
                    <div class="description-block">
                        <h5 class="description-header">Cidade</h5>
                        <span class="description-text">{{ $team->cityInfo->name }}</span>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="description-block">
                        <h5 class="description-header">Estado</h5>
                        <span class="description-text">{{ $team->cityInfo->stateInfo->name }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
