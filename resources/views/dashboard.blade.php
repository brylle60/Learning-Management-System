<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Welcome Message -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-2">Welcome back, {{ auth()->user()->name }}!</h3>
                    <p class="text-gray-600">
                        @if(auth()->user()->isInstructor())
                            You're logged in as an <span class="font-semibold text-indigo-600">Instructor</span>
                        @else
                            You're logged in as a <span class="font-semibold text-emerald-600">Student</span>
                        @endif
                    </p>
                </div>
            </div>  

            @if(auth()->user()->isStudent())
                <!-- Student: Enrolled Courses -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">My Enrolled Courses</h3>
                        
                        @if(auth()->user()->enrolledCourses->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach(auth()->user()->enrolledCourses as $course)
                                    <div class="border border-slate-200 rounded-lg overflow-hidden hover:shadow-md transition">
                                        <div class="h-32 bg-gradient-to-r from-indigo-500 via-purple-500 to-blue-500"></div>
                                        <div class="p-4">
                                            <h4 class="font-semibold text-lg text-gray-900 mb-2">{{ $course->title }}</h4>
                                            <p class="text-sm text-gray-600 mb-2">{{ Str::limit($course->short_description, 80) }}</p>
                                            <div class="flex items-center gap-2 text-xs text-gray-500 mb-4">
                                                <div class="h-2 w-2 rounded-full bg-emerald-500"></div>
                                                <span>By {{ $course->instructor->name }}</span>
                                            </div>
                                            
                                            @if($course->pivot->is_completed)
                                                <span class="inline-block px-3 py-1 text-xs font-medium bg-emerald-100 text-emerald-700 rounded-full mb-3">
                                                    ✓ Completed
                                                </span>
                                            @else
                                                <span class="inline-block px-3 py-1 text-xs font-medium bg-yellow-100 text-yellow-700 rounded-full mb-3">
                                                    In Progress
                                                </span>
                                            @endif

                                            <div class="flex gap-2">
                                                <a href="{{ route('courses.show', $course) }}" 
                                                   class="flex-1 text-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-500 transition">
                                                    View Course
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No courses yet</h3>
                                <p class="mt-1 text-sm text-gray-500">Get started by enrolling in a course.</p>
                                <div class="mt-6">
                                    <a href="{{ route('courses.index') }}" 
                                       class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-500 transition">
                                        Browse Courses
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            @if(auth()->user()->isInstructor())
                <!-- Instructor: My Courses -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-semibold text-gray-900">My Courses</h3>
                            <a href="{{ route('courses.create') }}" 
                               class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-500 transition">
                                + Create Course
                            </a>
                        </div>
                        
                        @if(auth()->user()->courses->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach(auth()->user()->courses as $course)
                                    <div class="border border-slate-200 rounded-lg overflow-hidden hover:shadow-md transition">
                                        <div class="h-32 bg-gradient-to-r from-indigo-500 via-purple-500 to-blue-500"></div>
                                        <div class="p-4">
                                            <h4 class="font-semibold text-lg text-gray-900 mb-2">{{ $course->title }}</h4>
                                            <p class="text-sm text-gray-600 mb-4">{{ Str::limit($course->short_description, 80) }}</p>
                                            
                                            <div class="text-xs text-gray-500 mb-4">
                                                <span class="font-medium">{{ $course->students->count() }}</span> students enrolled
                                            </div>

                                            <div class="flex gap-2">
                                                <a href="{{ route('courses.show', $course) }}" 
                                                   class="flex-1 text-center px-3 py-2 bg-slate-100 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-200 transition">
                                                    View
                                                </a>
                                                <a href="{{ route('courses.edit', $course) }}" 
                                                   class="flex-1 text-center px-3 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-500 transition">
                                                    Edit
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No courses yet</h3>
                                <p class="mt-1 text-sm text-gray-500">Get started by creating your first course.</p>
                                <div class="mt-6">
                                    <a href="{{ route('courses.create') }}" 
                                       class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-500 transition">
                                        Create Course
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>