{{-- @section('alpine')
    <script rel="text/javascript" src="/assets/js/components/Card.js"></script>
@endsection --}}

<div x-data="card">
    <p x-text="count"></p>
    <button x-on:click="increment">+</button>

    {{-- <div>
        <input type="text" wire:model.lazy="name">
        <p>{{ $name }}</p>
    </div> --}}
</div>

{{-- State --}}
<script>
    document.addEventListener('alpine:init', function () {
        Alpine.data('card', () => ({
            count: 0,

            increment() {
                this.count++
            }
        }))
    })
</script>