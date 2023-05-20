<div class="root">
    <div class="tab_box">
        @foreach($data as $key => $title)
            <button class="tab_button {{ $key == 0 ? 'active' : '' }} ">
                {{ $title }}
            </button>
        @endforeach
        <div class="line"></div>
    </div>
</div>

