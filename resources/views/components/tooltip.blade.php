<div class="tooltip">
    {{$slot}}
    <span class="tooltiptext">{{$message}}</span>
</div>

<style>
    .tooltip {
        position: relative;
        display: inline-block;
    }
    .tooltip .tooltiptext {
        visibility: hidden;
        width: 120px;
        background-color: white;
        color: var(--primary);
        text-align: center;
        border-radius: 6px;
        padding: 5px 1px;
        
        /* Position the tooltip */
        position: absolute;
        z-index: 1;
        top: -10px;
        right: 105%;
    }

    .tooltip:hover .tooltiptext {
        visibility: visible;
        border: 1px solid var(--primary);
    }
</style>

