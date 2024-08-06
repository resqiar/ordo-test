<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Books Data</title>
    <!-- Tailwind CSS / Flowbite -->
    @vite(['resources/css/app.css','resources/js/app.js'])
    <!-- HTMX -->
    <script src="https://unpkg.com/htmx.org@2.0.1" integrity="sha384-QWGpdj554B4ETpJJC9z+ZHJcA/i59TyjxEPXiiUgN2WmTyV5OEZWCD6gQhgkdpB/" crossorigin="anonymous"></script>
</head>

<body>
    <main class="px-12 mt-6 mb-16">
        <section>
            <div class="py-8 lg:py-16 px-4 mx-auto max-w-screen-md">
                <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white">Add New Book</h2>
                <form
                    hx-post="/create"
                    hx-target="#result"
                    enctype="multipart/form-data"
                    hx-disabled-elt="button[type='submit']"
                    class="space-y-8">
                    {{csrf_field()}}
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Name</label>
                        <input type="text" id="input-name" name="book_name" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 dark:shadow-sm-light" placeholder="24 Jam Bersama Gaspar" required>
                    </div>
                    <div>
                        <label for="author" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Author</label>
                        <input type="text" id="author" name="book_author" class="block p-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 dark:shadow-sm-light" placeholder="Sabda Armandio" required>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="descriptio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Description</label>
                        <textarea id="description" name="book_description" rows="6" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg shadow-sm border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Leave a description"></textarea>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                        <select id="status" name="book_status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="Draft" selected>Draft</option>
                            <option value="Published">Published</option>
                            <option value="Archived">Archived</option>
                        </select>
                        <label for="status" class="block mt-2 text-xs">Only published books will have unique url, drafted books will not be able to be deleted.</label>
                    </div>
                    <!-- Dropzone Input -->
                    <div class="flex flex-col w-full">
                        <label for="dropzone-file" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cover Image</label>
                        <div
                            id="dropzone-preview"
                            class="flex gap-4 overflow-x-auto *:max-h-[200px] *:my-4">
                        </div>
                        <button
                            title="Reset Image"
                            type="button"
                            id="dropzone-reset"
                            style="display:none;"
                            class="flex w-fit gap-2 items-center py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Reset Image
                        </button>

                        <div id="droppable-area">
                            <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG or GIF (MAX. 5MB)</p>
                                </div>
                                <input id="dropzone-file" name="book_cover" type="file" class="hidden" accept="image/png,image/jpg,image/jpeg,image/gif" />
                            </label>
                        </div>
                    </div>
                    <div id="result" class="px-12"></div>
                    <button type="submit" class="w-full py-3 px-5 text-sm font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-primary-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Create</button>
                </form>
            </div>
        </section>
    </main>

    <script>
        // @ts-check

        /**
         * @type {HTMLInputElement | null}
         */
        const dzInput = document.getElementById("dropzone-file");
        const dzPreview = document.getElementById("dropzone-preview");
        const dzRestoreElem = document.getElementById("dropzone-reset");

        /**
         * @type {FileList | null}
         */
        let dzFiles = null;

        dzRestoreElem?.addEventListener("click", dzRestore)
        dzInput?.addEventListener("change", function() {
            if (!this.files) return;
            if (!dzValidate(this.files)) return dzInput.value = "";

            dzFiles = this.files;
            dzPreviews();
        })

        function dzPreviews() {
            if (!dzFiles) return;

            /**
             * @type {Node[]}
             */
            const children = [];

            for (let i = 0; i < dzFiles.length; i++) {
                const file = dzFiles[i];
                if (!file) continue;

                // remove all children before appending new child
                dzPreview?.replaceChildren();

                const reader = new FileReader();
                reader.onload = function(e) {
                    const child = document.createElement("img");
                    child.src = e.target?.result?.toString() ?? "";
                    children.push(child);

                    // only invoke when reading reach the last file
                    if (children.length === dzFiles?.length) {
                        dzPreview?.replaceChildren(...children);
                        dzShowReset();
                    }
                }
                reader.readAsDataURL(file);
            }
        }

        /**
         * @param files {FileList}
         * @returns boolean
         */
        function dzValidate(files) {
            if (files.length > 1) {
                alert("Max number of image allowed is only 1");
                return false;
            }

            for (let i = 0; i < files.length; i++) {
                const file = files[i];

                if (!file.type.startsWith("image/")) {
                    alert(`"${file.name}" is not an image`);
                    return false;
                };

                const maxSize = 5 * 1024 * 1024; // 5 MB
                if (file.size > maxSize) {
                    alert(`"${file.name}" is exceeding 5MB size`);
                    return false;
                }
            }

            return true;
        }

        function dzRestore() {
            if (!dzPreview || !dzInput) return;

            dzFiles = null;
            dzPreview.replaceChildren();
            dzInput.value = "";

            dzShowReset(false);
        }

        /**
         * @param show {Boolean}
         * @returns void
         */
        function dzShowReset(show = true) {
            if (!dzRestoreElem) return;
            if (show) {
                dzRestoreElem.style.display = "flex";
            } else {
                dzRestoreElem.style.display = "none";
            }
        }

        const dzArea = document.getElementById("droppable-area");

        ;
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dzArea?.addEventListener(eventName, function(e) {
                e.preventDefault();
                e.stopPropagation();
            })
        });

        ;
        ['dragenter', 'dragover'].forEach(eventName => {
            dzArea?.addEventListener(eventName, () => dzHighlight(true))
        });

        ;
        ['dragleave', 'drop'].forEach(eventName => {
            dzArea?.addEventListener(eventName, () => dzHighlight(false))
        });

        /**
         * @param h {Boolean}
         * @returns void
         */
        function dzHighlight(h = true) {
            if (!dzArea) return;
            h ? dzArea.style.border = "2px dashed yellow" :
                dzArea.style.border = "none";
        }

        dzArea?.addEventListener("drop", dzDrop);

        /**
         * @param e {DragEvent}
         * @returns void
         */
        function dzDrop(e) {
            let dataTransfer = e.dataTransfer;
            let files = dataTransfer?.files;

            if (!dzInput || !files) return;
            if (!dzValidate(files)) return dzInput.value = "";

            dzFiles = files;
            dzPreviews();

            // inject dragged files into HTML input
            dzInput.files = files;
        }
    </script>
</body>

</html>
