<!-- Main modal -->
<div id="crud-modal1" tabindex="-1" aria-hidden="true"
    class="hidden bg-black bg-opacity-50 overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Create New Product
                </h3>
                <button type="button" onclick="closeUpdateModal()"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form class="p-4 md:p-5" id="data">
                <div class="grid gap-4 mb-4 grid-cols-2">

                    <div class="col-span-2">
                        <label for="product_id" class="block mb-2 text-sm font-medium ">Product Id</label>
                        <input type="text" id="p-id" name="product_id"
                            class="border text-sm rounded-lg block w-full p-2.5">
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        <label for="name" class="block mb-2 text-sm font-medium ">Name</label>
                        <input type="text" id="p-name" name="name"
                            class="border text-sm rounded-lg block w-full p-2.5">
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        <label for="price" class="block mb-2 text-sm font-medium ">Price</label>
                        <input type="text" id="p-price" name="price"
                            class="border text-sm rounded-lg block w-full p-2.5">
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        <label for="product_details" class="block mb-2 text-sm font-medium ">Product Details</label>
                        <input type="text" id="p-details" name="product_details"
                            class="border text-sm rounded-lg block w-full p-2.5">
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        <label for="image" class="block mb-2 text-sm font-medium ">Image</label>
                        <input type="file" id="p-image" name="image"
                            class="border text-sm rounded-lg block w-full p-2.5">
                    </div>
                    <div id="show-product">

                    </div>

                </div>
                <button onclick="updateProduct()" type="button"
                    class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Update Product
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    async function openUpdateModal(id) {

        try {
            document.getElementById('data').reset();
            const modal = document.getElementById('crud-modal1');
            modal.classList.remove('hidden');
            productId = id
            let url = `/find-update/${productId}`;
            let res = await axios.get(url);
            console.log(res);
            let product = res.data.data;

            document.getElementById('p-id').value = product.product_id;
            document.getElementById('p-name').value = product.name;
            document.getElementById('p-price').value = product.price;
            document.getElementById('p-details').value = product.product_details;

            document.getElementById('show-product').innerHTML = `
    <img src="/image/${product.images}" alt="product_image" height="100px" width="100px">`

        }catch(error){
            alert(error);
        }

    }

    function closeUpdateModal() {
        const modal = document.getElementById('crud-modal1');
        modal.classList.add('hidden');
    }

    async function updateProduct() {
        try {
            const url = `/update/${productId}`;

            const id = document.getElementById('p-id').value;
            const productName = document.getElementById('p-name').value;
            const productPrice = document.getElementById('p-price').value;
            const productDetails = document.getElementById('p-details').value;
            const productImage = document.getElementById('p-image').files[0];

            const formData = new FormData();

            formData.append('product_id', id);
            formData.append('name', productName);
            formData.append('price', productPrice);
            formData.append('product_details', productDetails);

            if(productImage){
                formData.append('images', productImage);
            }



            closeUpdateModal();
            const response = await axios.post(url, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                }
            });


            document.getElementById('list').innerHTML = '';
            listProduct();

        } catch (error) {
            console.log(error);
            alert(error);

        }
    }
</script>
