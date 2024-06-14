<?php
        $products = json_decode(file_get_contents('./../assets/data.json'), true);
        $totalProducts = count($products);
        $latestProducts = 4; //quantity of prodacts to display
        ?>

        <!-- <div class="mt-3 mx-0 p-0"> -->
            <div class="row-last-products">
                <?php for ($i = $totalProducts - $latestProducts; $i < $totalProducts; $i++): ?>
                    <div class="mb-4 custom-card p-2">
                    <!-- add class custom-card -->
                        <!-- <div class="custom-card p-2">  -->
                            <img src="<?php echo htmlspecialchars($products[$i]['image_url']); ?>" class="small-card-image" alt="<?php echo htmlspecialchars($products[$i]['product']); ?>">
                            <div class="card-body-container">  
                                <div class="small-card-content">
                                   <h6 class="small-card-title"><?php echo htmlspecialchars($products[$i]['product']); ?></h6>
                                   <p class="small-card-text">$<?php echo htmlspecialchars($products[$i]['price']); ?></p>
                                </div>                           
                                <div><button onclick="addToCart(<?php echo $products[$i]['id']; ?>)" class="btn btn-primary small-card-button p-2">Add to Cart</button> </div>
                            </div>
                        <!-- </div> -->
                    </div>
                <?php endfor; ?>
            </div>
        <!-- </div> -->