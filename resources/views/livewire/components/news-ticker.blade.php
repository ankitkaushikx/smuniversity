<div class="news-ticker bg-red-600 ">
    <div class="ticker-wrapper ">
     
       @foreach ($headings as $heading )
         <a href="" class="ticker-item"> &diams; {{$heading->heading}} 
          </a>
        
       @endforeach
 
    </div>
</div>   