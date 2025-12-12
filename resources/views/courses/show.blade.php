<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2">
            <p class="text-sm text-slate-500">Course</p>
            <h1 class="text-2xl font-semibold text-slate-900">{{ $course->title }}</h1>
            <div class="flex items-center gap-2 text-sm text-slate-500">
                <div class="h-2 w-2 rounded-full bg-emerald-500"></div>
                <span>By {{ $course->instructor?->name ?? 'Unknown instructor' }}</span>
            </div>
        </div>
    </x-slot>

    <div class="bg-slate-50 py-12">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">
                <div class="h-32 bg-gradient-to-r from-indigo-500 via-purple-500 to-blue-500"></div>
                <div class="p-8">
                    <p class="text-lg text-slate-700">{{ $course->short_description }}</p>

                    <div class="mt-8 border-t border-slate-100 pt-6">
                        <h2 class="text-xl font-semibold text-slate-900">Course content</h2>
                        <div class="prose prose-slate mt-4 max-w-none">
                            {!! nl2br(e($course->content)) !!}
                        </div>
                    </div>

                    <div class="mt-8 flex flex-wrap items-center gap-3">
                        <a href="{{ route('courses.index') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                            ← Back to courses
                        </a>
                        
                        @if(auth()->check())
                            @if(auth()->user()->id === $course->instructor_id)
                                {{-- Instructor buttons --}}
                                <a href="{{ route('courses.edit', $course) }}" class="inline-flex items-center gap-2 rounded-full bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-500">
                                    Edit course
                                </a>
                                <form action="{{ route('courses.destroy', $course) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this course? This action cannot be undone.');"
                                      class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="inline-flex items-center gap-2 rounded-full bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-red-500">
                                        Delete course
                                    </button>
                                </form>
                            @else
                                {{-- Student buttons --}}
                                @if(auth()->user()->enrolledCourses->contains($course->id))
                                    <button class="inline-flex items-center gap-2 rounded-full bg-emerald-600 px-4 py-2 text-sm font-medium text-white shadow-sm cursor-default">
                                        ✓ Enrolled
                                    </button>
                                    <form action="{{ route('courses.unenroll', $course) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Are you sure you want to unenroll from this course?');"
                                          class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center gap-2 rounded-full bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-red-500">
                                            Unenroll
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('courses.enroll', $course) }}" 
                                          method="POST" 
                                          class="inline-block">
                                        @csrf
                                        <button type="submit" 
                                                class="inline-flex items-center gap-2 rounded-full bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-500">
                                            Enroll in course
                                        </button>
                                    </form>
                                @endif
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>