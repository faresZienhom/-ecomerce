<div>


      @foreach($categories as $category)

      <li class="nav__link nav__side-link"><a href="/shop" class="py-3">{{ $category->name }} </a></li>
      @endforeach
    </ul>
  </div>
