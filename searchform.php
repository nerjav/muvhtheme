<form id="header-search" action="<?php echo esc_url(home_url('/')); ?>" method="GET">
    <div class="form-group">
        <div class="input-group input-group-sm col-md-6 col-lg-12">
            <input 
                name="s"
                class="form-control" 
                type="text" 
                placeholder="Buscar" 
                id="search-input"
                aria-label="Buscar"
                value="<?php echo get_search_query()?>"/>
            <div class="input-group-append">
                <button 
                    aria-label="Realizar Búsqueda"
                    type="submit"
                    class="btn btn-outline-secondary">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>
</form>