<!-- Main modal -->
<div id="crud-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Create New Product
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-toggle="crud-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form class="p-4 md:p-5" id="create-form">
                <div class="grid gap-4 mb-4 grid-cols-2">

                    <div class="col-span-2">
                        <label for="product_id" class="block mb-2 text-sm font-medium ">Product Id</label>
                        <input type="text" id="product-id" name="product_id"
                            class="border text-sm rounded-lg block w-full p-2.5">
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        <label for="name" class="block mb-2 text-sm font-medium ">Name</label>
                        <input type="text" id="name" name="name"
                            class="border text-sm rounded-lg block w-full p-2.5">
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        <label for="price" class="block mb-2 text-sm font-medium ">Price</label>
                        <input type="text" id="price" name="price"
                            class="border text-sm rounded-lg block w-full p-2.5">
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        <label for="product_details" class="block mb-2 text-sm font-medium ">Product Details</label>
                        <input type="text" id="product-details" name="product_details"
                            class="border text-sm rounded-lg block w-full p-2.5">
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        <label for="image" class="block mb-2 text-sm font-medium ">Image</label>
                        <input type="file" id="image" name="image"
                            class="border text-sm rounded-lg block w-full p-2.5">
                    </div>

                </div>
                <button onclick="createProduct()" data-modal-toggle="crud-modal" type="button"
                    class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Add new product
                </button>
            </form>
        </div>
    </div>
</div>

<script>


    async function createProduct() {

        const url = '/create';
        const id = document.getElementById('product-id').value;
        const productName = document.getElementById('name').value;
        const productPrice = document.getElementById('price').value;
        const productDetails = document.getElementById('product-details').value;
        const productImage = document.getElementById('image').files[0];


        const formData = new FormData();
        formData.append('product_id', id);
        formData.append('name', productName);
        formData.append('price', productPrice);
        formData.append('product_details', productDetails);
        formData.append('images', productImage);


        try {
            const response = await axios.post(url, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                }
            });
            alert('Product created successfully!');
            document.getElementById('create-form').reset();
            document.getElementById('crud-modal').classList.add('hidden');
            document.getElementById('list').innerHTML = '';
            listProduct();
            document.getElementById('create-form').reset();
        } catch (error) {
            console.error('Error creating product:', error);
            alert('An error occurred. Please try again.');
        }
    }
</script>
