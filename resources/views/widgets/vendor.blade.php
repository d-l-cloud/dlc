@if($vendor->count()>0)
    <section>
        <div class="hits">
            <h2 class="slider-header" style="margin-bottom: -75px;">Наши бренды</h2>
            <div class="brands-item additional-slider container"
                 data-infinity="1"
                 data-variable-width="1" data-compare="0">
                @foreach($vendor as $vendorItem)
                    <a href="{{ route('manufacturerItem', $vendorItem->id) }}">
                        <div class="card item-in-slider">
                            <div class="face face1">
                                <div class="content">
                                    <h3>{{ $vendorItem->name }}</h3>
                                </div>
                            </div>
                            <div class="face face2">
                                <div class="content">
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
    </section>
@endif
