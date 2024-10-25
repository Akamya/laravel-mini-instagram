<div {{ $attributes->merge(['class' => 'rounded-full overflow-hidden']) }}>
    @if ($user->pdp)
    <img
      class="w-full h-full aspect-square object-cover object-center"
      src="{{ asset('storage/' . $user->pdp) }}"
      alt="{{ $user->username }}"
    />
    @else
    <div class="w-full h-full aspect-square flex items-center justify-center bg-indigo-100">
      <span class="text-2xl font-medium text-indigo-800">
        {{ $user->username[0] }}
      </span>
    </div>
    @endif
  </div>
