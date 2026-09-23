<x-filament-panels::page>
    @php
        /** @var \App\Models\ContactMessage $msg */
        $msg = $this->record;
        $replies = $msg->replies()->orderBy('created_at')->get();
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- LEFT: thread --}}
        <div class="lg:col-span-2 space-y-4">

            {{-- Original message --}}
            <x-filament::section>
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <x-filament::badge color="primary">Inbound</x-filament::badge>
                        <span class="text-sm font-semibold">{{ $msg->name }}</span>
                        <span class="text-xs text-gray-500">&lt;{{ $msg->email }}&gt;</span>
                    </div>
                    <span class="text-xs text-gray-500">
                        {{ $msg->created_at->format('M j, Y · g:i A') }}
                    </span>
                </div>

                @if ($msg->project_type)
                    <div class="mb-3 text-xs">
                        <x-filament::badge color="gray">
                            {{ ucfirst(str_replace('_', ' ', $msg->project_type)) }}
                        </x-filament::badge>
                    </div>
                @endif

                <div class="whitespace-pre-wrap text-sm leading-relaxed">{{ $msg->message }}</div>
            </x-filament::section>

            {{-- Replies thread --}}
            @foreach ($replies as $reply)
                <x-filament::section>
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-2">
                            <x-filament::badge :color="$reply->direction === 'outbound' ? 'success' : 'gray'">
                                {{ $reply->direction === 'outbound' ? 'You replied' : 'Customer replied' }}
                            </x-filament::badge>
                            @if ($reply->emailed_at)
                                <span class="text-xs text-gray-500">emailed</span>
                            @endif
                        </div>
                        <span class="text-xs text-gray-500">
                            {{ $reply->created_at->format('M j, Y · g:i A') }}
                        </span>
                    </div>
                    <div class="whitespace-pre-wrap text-sm leading-relaxed">{{ $reply->body }}</div>
                </x-filament::section>
            @endforeach

            {{-- Reply form --}}
            <x-filament::section>
                <h3 class="font-semibold mb-3">Reply to {{ $msg->name }}</h3>

                <form wire:submit="sendReply" class="space-y-4">
                    <textarea
                        wire:model="replyBody"
                        rows="6"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 px-3 py-2 focus:border-primary-500 focus:ring-primary-500"
                        placeholder="Type your reply…"
                        required
                    ></textarea>

                    @error('replyBody')
                        <p class="text-sm text-danger-600">{{ $message }}</p>
                    @enderror

                    <div class="flex items-center gap-3">
                        <x-filament::button type="submit" icon="heroicon-o-paper-airplane">
                            Send Reply
                        </x-filament::button>

                        <span class="text-xs text-gray-500">
                            Sends to {{ $msg->email }} · reply lands back on this thread
                        </span>
                    </div>
                </form>
            </x-filament::section>
        </div>

        {{-- RIGHT: sidebar --}}
        <div class="space-y-4">

            <x-filament::section heading="Contact Details">
                <dl class="space-y-3 text-sm">
                    <div>
                        <dt class="text-xs uppercase tracking-wider text-gray-500">Name</dt>
                        <dd class="font-semibold">{{ $msg->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs uppercase tracking-wider text-gray-500">Email</dt>
                        <dd><a href="mailto:{{ $msg->email }}" class="text-primary-600 hover:underline">{{ $msg->email }}</a></dd>
                    </div>
                    @if ($msg->phone)
                        <div>
                            <dt class="text-xs uppercase tracking-wider text-gray-500">Phone</dt>
                            <dd><a href="tel:{{ $msg->phone }}" class="text-primary-600 hover:underline">{{ $msg->phone }}</a></dd>
                        </div>
                    @endif
                    @if ($msg->company)
                        <div>
                            <dt class="text-xs uppercase tracking-wider text-gray-500">Company</dt>
                            <dd>{{ $msg->company }}</dd>
                        </div>
                    @endif
                    @if ($msg->project_type)
                        <div>
                            <dt class="text-xs uppercase tracking-wider text-gray-500">Project type</dt>
                            <dd>{{ ucfirst(str_replace('_', ' ', $msg->project_type)) }}</dd>
                        </div>
                    @endif
                </dl>
            </x-filament::section>

            <x-filament::section heading="Thread">
                <dl class="space-y-3 text-sm">
                    <div>
                        <dt class="text-xs uppercase tracking-wider text-gray-500">Received</dt>
                        <dd>{{ $msg->created_at->format('M j, Y · g:i A') }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs uppercase tracking-wider text-gray-500">Last activity</dt>
                        <dd>{{ $msg->last_activity_at?->diffForHumans() ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs uppercase tracking-wider text-gray-500">Replies</dt>
                        <dd>{{ $replies->count() }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs uppercase tracking-wider text-gray-500">Public thread</dt>
                        <dd>
                            <a href="{{ $msg->reply_url }}" target="_blank" class="text-primary-600 hover:underline text-xs break-all">
                                {{ $msg->reply_url }}
                            </a>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs uppercase tracking-wider text-gray-500">IP address</dt>
                        <dd class="text-xs text-gray-500">{{ $msg->ip_address ?? '—' }}</dd>
                    </div>
                </dl>
            </x-filament::section>

            <x-filament::section heading="Quick actions">
                <div class="flex flex-col gap-2">
                    <x-filament::button
                        tag="a"
                        href="mailto:{{ $msg->email }}?subject=Re: your enquiry — Wuba 58 City Models"
                        target="_blank"
                        color="gray"
                        icon="heroicon-o-arrow-uturn-left"
                        class="w-full"
                    >
                        Open in email client
                    </x-filament::button>

                    <x-filament::button
                        tag="a"
                        href="{{ $msg->reply_url }}"
                        target="_blank"
                        color="gray"
                        icon="heroicon-o-arrow-top-right-on-square"
                        class="w-full"
                    >
                        Open public thread
                    </x-filament::button>
                </div>
            </x-filament::section>

        </div>
    </div>
</x-filament-panels::page>