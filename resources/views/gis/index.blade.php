@extends('layouts.bickery')

@section('content')
<div class="text-center" style="width:100%;">
    <select class="form-select text-center" aria-label="Default select example">
        <option selected value="3374">Kabupaten / Kota</option>
        @foreach($maps as $map)
        <option value="{{ $map->district_id }}">{{ $map->district  }}</option>
        @endforeach
    </select>
</div>

<div id="map">
    <style>
        .embed-container {
            position: relative;
            padding-bottom: 44%;
            height: 0;
            max-width: 100%;
        }

        .embed-container iframe,
        .embed-container object,
        .embed-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        small {
            position: absolute;
            z-index: 40;
            bottom: 0;
            margin-bottom: -15px;
        }
    </style>
    <div class="embed-container"><iframe width="800" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" title="Kota Tegal" src="//www.arcgis.com/apps/Embed/index.html?webmap=362f18c0e28a4896b0847a8f9fb2e036&extent=109.0523,-6.9053,109.1791,-6.8335&home=true&zoom=true&previewImage=false&scale=true&details=true&legendlayers=true&active_panel=details&basemap_gallery=true&disable_scroll=false&theme=light"></iframe></div>
</div>


<script>
    $('select').change(function() {

        var district_id = $(this).val();

        $.ajax({
            type: 'get',
            url: '/gis/' + district_id,
            data: {
                'district_id': district_id
            },

            success: function(data) {
                $('#map').empty();
                $('#map').html(data);
            }
        });
    });
</script>
@endsection