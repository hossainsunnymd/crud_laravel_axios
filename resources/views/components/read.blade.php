<h1 class="text-center p-5 text-[25px]">Product Management Tool</h1>
<div class="max-w-[1300px] mx-auto p-4 flex justify-between">
    <input oninput="findProduct()" id="find" class="w-[350px] h-[30px] rounded-sm px-3 border-gray-800 border" type="text" placeholder="search by id or name .....">
    <button data-modal-target="crud-modal" data-modal-toggle="crud-modal" class="  text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
        Create Product
        </button>
</div>
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table id="default-table" class="w-[1000px] mx-auto text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">

        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr >
                <th scope="col" class="px-16 py-3">
                    Image
                </th>
                <th scope="col" class="px-16 py-3">
                   Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Product_id
                </th>
                <th scope="col" class="px-6 py-3">
                    Product_details
                </th>
                <th scope="col" class="px-6 py-3">
                    Price
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>

            </tr>
        </thead>
        <tbody id='list'>
          {{-- products binds here --}}
        </tbody>
    </table>
</div>

<div id="popup-modal" tabindex="-1" class="hidden fixed inset-0 z-50 flex justify-center items-center bg-black bg-opacity-50">
    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700 w-full max-w-md">
        <!-- Close Button -->
        <button type="button" onclick="closeDeleteModal()" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
            <span class="sr-only">Close modal</span>
        </button>

        <!-- Modal Content -->
        <div class="p-6 text-center">
            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
            </svg>
            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete this product?</h3>
            <button type="button" onclick="deleteProduct()" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center" data-modal-hide="popup-modal">
                Yes, I'm sure
            </button>
            <button type="button" onclick="closeDeleteModal()" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" data-modal-hide="popup-modal">
                No, cancel
            </button>
        </div>
    </div>
</div>


<script>

if (document.getElementById("default-table") && typeof simpleDatatables.DataTable !== 'undefined') {
    const dataTable = new simpleDatatables.DataTable("#default-table", {
        searchable: false,
        perPageSelect: false
    });
}

    listProduct();
    async function listProduct() {
    const url = '/product-list';


        let res = await axios.get(url);
        console.log(res);
        res.data.data.forEach(element => {
            document.getElementById('list').innerHTML+=`
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4 text-center"> <img src="image/${element['images']}" alt="product_image" height='100px' width='100px' /> </td>
                    <td class="px-6 py-4 text-center">${element['name']}</td>
                    <td class="px-6 py-4 text-center">${element['product_id']}</td>
                    <td class="px-6 py-4 text-center">${element['product_details']}</td>
                    <td class="px-6 py-4 text-center">${element['price']}</td>
                    <td class="flex gap-5 items-center justify-center h-[100px]">

                     <button onclick="openDeleteModal(${element['id']})" class="block text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-1 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" type="button">
                     Delete
                    </button>

                     <button onclick="openUpdateModal(${element['id']})" class="block text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-1 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" type="button">
                     Edit
                    </button>

                    </td>
                </tr>

            `
        });

}

      async function findProduct() {
       let find= document.getElementById('find').value;
       let url=`/find-product/${find}`
       if(find){
       document.getElementById('list').innerHTML='';
       let res= await axios.get(url);
       res.data.data.forEach(element => {
            document.getElementById('list').innerHTML+=`
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4 text-center"> <img src="image/${element['images']}" alt="product_image" height='100px' width='100px' /> </td>
                    <td class="px-6 py-4 text-center">${element['name']}</td>
                    <td class="px-6 py-4 text-center">${element['product_id']}</td>
                    <td class="px-6 py-4 text-center">${element['product_details']}</td>
                    <td class="px-6 py-4 text-center">${element['price']}</td>
                    <td class="flex gap-5 items-center justify-center h-[100px]">

                     <button onclick="openDeleteModal(${element['id']})" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-1 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" type="button">
                     Delete
                    </button>

                     <button onclick="openUpdateModal(${element['id']})" class=" text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-1 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" type="button">
                     Edit
                    </button>

                    </td>
                </tr>

            `
        });
    }else{
        document.getElementById('list').innerHTML='';
        listProduct();
    }

    }

    let productId=null;

    function openDeleteModal(id){
        productId=id
        const modal=document.getElementById('popup-modal');
        modal.classList.remove('hidden');
    }

    function closeDeleteModal(){
        const modal=document.getElementById('popup-modal');
        modal.classList.add('hidden');
    }

   async function deleteProduct(){

        try{
         let url=`/product/delete/${productId}`
         await axios.get(url);
         closeDeleteModal();
         document.getElementById('list').innerHTML='';
         listProduct();
        }catch(error){
            console.error(error);
            alert(error);
        }

    }



</script>



