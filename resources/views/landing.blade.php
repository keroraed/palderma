<x-app-layout :settings="$settings">

  @include('sections.header')

  <div dir="rtl" style="width:100%;overflow-x:hidden">
    @foreach($sections as $section)
      @if($section->is_visible)
        @switch($section->key)
          @case('hero')
            @include('sections.hero')
            @break
          @case('stats')
            @include('sections.stats')
            @break
          @case('about')
            @include('sections.about', ['sectionInfo' => $section])
            @break
          @case('doctors')
            @include('sections.doctors', ['sectionInfo' => $section])
            @break
          @case('spotlight')
            @include('sections.spotlight', ['sectionInfo' => $section])
            @break
          @case('services')
            @include('sections.services', ['sectionInfo' => $section])
            @break
          @case('trust')
            @include('sections.trust', ['sectionInfo' => $section])
            @break
          @case('before_after')
            @include('sections.before-after', ['sectionInfo' => $section])
            @break
          @case('packages')
            @include('sections.packages', ['sectionInfo' => $section])
            @break
          @case('booking')
            @include('sections.booking', ['sectionInfo' => $section])
            @break
          @case('faq')
            @include('sections.faq', ['sectionInfo' => $section])
            @break
          @case('footer')
            @include('sections.footer')
            @break
        @endswitch
      @endif
    @endforeach
  </div>

  @include('sections.doctor-modal')

</x-app-layout>
