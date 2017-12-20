<div>
    <ul class="nav nav-tabs">
       <li class="tabs-list-li @if($active_tab == 'dish') {{'active'}} @endif"><a attr-id="1" href="{{ route('food_nearby') }}" class="tabs-list">Dish</a></li>
        <li class="tabs-list-li @if($active_tab == 'restaurant') {{'active'}} @endif"><a attr-id="2" href="{{ route('restaurant_nearby') }}" class="tabs-list">Restaurants</a></li>
        <li class="tabs-list-li @if($active_tab == 'favorite') {{'active'}} @endif">
            <a attr-id="3" href="{{ route('restaurant_favourite') }}" class="tabs-list" id="favorite_tab">Favoris</a>                                
        </li>                                    
    </ul>
</div>  