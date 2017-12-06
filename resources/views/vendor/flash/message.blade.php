@if (session('flash_notification'))
    <ul class="alerts-list">
        @foreach (session('flash_notification', collect())->toArray() as $message)
            @if ($message['overlay'])
                @include('flash::modal', [
                    'modalClass' => 'flash-modal',
                    'title'      => $message['title'],
                    'body'       => $message['message']
                ])
            @else
                <li class="alert
                            alert-{{ $message['level'] }}
                            {{ $message['important'] ? 'alert-important' : '' }}"
                            role="alert"
                >
                    @if ($message['important'])
                        <button type="button"
                                class="close"
                                data-dismiss="alert"
                                aria-hidden="true"
                        >&times;</button>
                    @endif

                    {!! $message['message'] !!}
                </li>
            @endif
        @endforeach
    </ul>
@endif

{{ session()->forget('flash_notification') }}
