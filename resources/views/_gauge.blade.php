<svg class="gauge {{ $class ?? ''}} {{get_color_for_score($percentage)}}"
     viewbox="0 0 36 36"
     xmlns="http://www.w3.org/2000/svg">
    @if(is_numeric($percentage))
        <path class="gauge-bg"
              d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
        ></path>

        <path class="gauge-circle" stroke-dasharray="{{ $percentage }}, 100"
              d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
        ></path>
    @endif

    <text text-anchor="middle" alignment-baseline="central" x="18" y="18" class="dark-gray">
        {{ $percentage ?? '-'}}
    </text>
</svg>
