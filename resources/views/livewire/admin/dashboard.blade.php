<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header with User Info -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Dashboard Overview</h1>
            <p class="mt-1 text-gray-600">Welcome back, {{ auth()->user()->name }} . Here's what's happening today.</p>
        </div>
        <div class="flex items-center space-x-4 bg-white p-3 rounded-lg shadow-sm border border-gray-100">
            <div class="relative">
                <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-medium">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <span class="absolute bottom-0 right-0 block h-2.5 w-2.5 rounded-full bg-green-400 ring-2 ring-white"></span>
            </div>
            <div>
                <p class="font-medium text-gray-800">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-500">Admin</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        @php
            $statsData = [
                ['label' => 'Total Posts', 'value' => $stats['total_posts'], 'color' => 'indigo', 'icon' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z'],
                ['label' => 'Published', 'value' => $stats['published_posts'], 'color' => 'emerald', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['label' => 'Total Users', 'value' => $stats['total_users'], 'color' => 'violet', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                ['label' => 'Pending Comments', 'value' => $stats['pending_comments'], 'color' => 'amber', 'icon' => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z'],
            ];
        @endphp

        @foreach($statsData as $stat)
        <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm hover:shadow-lg transition-all group">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">{{ $stat['label'] }}</p>
                    <p class="text-2xl font-semibold text-gray-800 mt-1">{{ $stat['value'] }}</p>
                </div>
                <div class="p-3 rounded-lg bg-{{ $stat['color'] }}-50 group-hover:bg-{{ $stat['color'] }}-100 transition-colors">
                    <svg class="w-6 h-6 text-{{ $stat['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}" />
                    </svg>
                </div>
            </div>
            @if($loop->first)
            <div class="mt-4 pt-4 border-t border-gray-100">
                <p class="text-xs text-gray-500">Since last week: <span class="text-emerald-600 font-medium">+12%</span></p>
            </div>
            @endif
        </div>
        @endforeach
    </div>

    <!-- Main Content Area -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Quick Actions -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    @php
                        $actions = [
                            // ['label' => 'Create New Post', 'route' => 'admin.posts.create', 'color' => 'indigo', 'icon' => 'M12 6v6m0 0v6m0-6h6m-6 0H6'],
                            ['label' => 'Manage Posts', 'route' => 'admin.posts', 'color' => 'blue', 'icon' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z'],
                            ['label' => 'Manage Comments', 'route' => 'admin.comments', 'color' => 'emerald', 'icon' => 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z'],
                            ['label' => 'Manage Users', 'route' => 'admin.users', 'color' => 'violet', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                        ];
                    @endphp

                    @foreach($actions as $action)
                    <a href="{{ route($action['route']) }}" class="block">
                        <div class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors group">
                            <div class="p-2 rounded-lg bg-{{ $action['color'] }}-50 group-hover:bg-{{ $action['color'] }}-100 transition-colors mr-3">
                                <svg class="w-5 h-5 text-{{ $action['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $action['icon'] }}" />
                                </svg>
                            </div>
                            <span class="font-medium text-gray-700 group-hover:text-{{ $action['color'] }}-600 transition-colors">{{ $action['label'] }}</span>
                            <svg class="w-4 h-4 ml-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Recent Posts -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Recent Posts</h3>
                    <a href="{{ route('admin.posts') }}" class="text-sm text-blue-600 hover:underline flex items-center">
                        View All
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
                <div class="space-y-4">
                    @foreach($recentPosts as $post)
                    {{-- <a href="{{ route('admin.posts.edit', $post->id) }}" class="block hover:bg-gray-50 rounded-lg p-3 transition-colors"> --}}
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0 h-10 w-10 bg-gray-100 rounded-lg flex items-center justify-center text-gray-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800"><a href="{{ route('posts.show', $post->slug) }}" class="hover:text-indigo-600 transition-colors">
                                        {{ Str::limit($post->title, 40) }}</a></p>
                                    <div class="flex items-center text-sm text-gray-500 mt-1">
                                        <span>{{ $post->user->name }}</span>
                                        <span class="mx-2">•</span>
                                        <span>{{ $post->created_at->format('M d, Y') }}</span>
                                        @if($post->published())
                                        <span class="ml-2 px-2 py-0.5 text-xs bg-emerald-100 text-emerald-800 rounded-full">Published</span>
                                        @else
                                        <span class="ml-2 px-2 py-0.5 text-xs bg-amber-100 text-amber-800 rounded-full">Draft</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <span class="text-sm text-gray-400">{{ $post->created_at->diffForHumans() }}</span>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Comments -->
    <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm mb-8">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Pending Comments</h3>
            <a href="{{ route('admin.comments') }}" class="text-sm text-blue-600 hover:underline flex items-center">
                View All
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        @if($pendingComments->count() > 0)
        <div class="divide-y divide-gray-100">
            @foreach($pendingComments as $comment)
            <div class="py-4">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0 h-10 w-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-500 font-medium">
                        {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-gray-800">{{ $comment->user->name }}</p>
                            <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-sm text-gray-600 mt-1">{{ Str::limit($comment->content, 120) }}</p>
                        <div class="mt-2 flex items-center text-xs text-gray-500">
                            <span>On: </span>
                            <a href="{{ route('posts.show', $comment->post) }}" class="ml-1 text-blue-600 hover:underline">{{ Str::limit($comment->post->title, 40) }}</a>
                        </div>
                        <div class="mt-3 flex space-x-2">
                            <button wire:click="approveComment({{ $comment->id }})" class="text-xs px-3 py-1 bg-emerald-100 text-emerald-800 rounded-full hover:bg-emerald-200 transition-colors">
                                Approve
                            </button>
                            <button wire:click="deleteComment({{ $comment->id }})" class="text-xs px-3 py-1 bg-red-100 text-red-800 rounded-full hover:bg-red-200 transition-colors">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-8">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
            <h4 class="mt-2 text-sm font-medium text-gray-900">No pending comments</h4>
            <p class="mt-1 text-sm text-gray-500">All comments have been moderated.</p>
        </div>
        @endif
    </div>

    <!-- System Status -->

</div>
