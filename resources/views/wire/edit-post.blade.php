<x-layout>
    @include('components.wire.dash-navbar')
    <div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg p-6 mt-10">

        <form action="{{route('update.post' ,$post->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <!-- Title -->
            <div class="mb-4">
                <input type="hidden" name="requestUrl" value="{{ url()->previous() }}">
                <label for="title" class="block text-md font-medium text-gray-700">Title</label>
                <input  type="text" name="title" id="title" value=" {{ old('title',$post->title) }}"  class="text-left resize-none mt-1 p-2 w-full text-2xl md:text-3xl border-none ring-b-2 focus:ring-0 font-semibold outline-none" placeholder="Title">

                @error('title')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Content -->
            <div id="editor" class="h-[300px]"></div>
            <input type="hidden" name="content" id="content"/>
            <input type="hidden" name="readmore" id="readmore"/>

            <!-- Image Upload -->
            <div class="my-4 text-black text-md ">
                <x-bladewind::filepicker  name="image" placeholder="Choose a Thumbnail" accepted_file_types=".jpg, .png" />
                @error('image')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            {{$post->$categories}}
            <x-bladewind::select
                name="categories"
                searchable="true"
                label_key="name"
                value_key="id"
                multiple="true"
                selected_value="{{ implode(',',$post->categorieIds)}}"
                label="Select Categories"
                max_selectable="5"
                class=" "
                :data="$categories" />

            <x-bladewind::select
                name="authors"
                searchable="true"
                label_key="name"
                value_key="id"
                multiple="true"
                selected_value="{{ implode(',',$post->authorIds)}}"
                label="Select Authors"
                max_selectable="5"
                :data="$authors" />

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-md">
                    Update Post
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var quill = new Quill("#editor", {
                theme: "snow",
                placeholder: "Write your blog...",
                modules: {
                    toolbar: [
                        [{ header: [1, 2, false] }],
                        ["bold", "italic", "underline"],
                        ["image", "code-block"],
                    ],
                },
            });

            // Set the initial value of the Quill editor
            var initialContent = @json(old('content', $post->content_text));  // Pass the data to JavaScript
            quill.root.innerHTML = initialContent;

            let contentInput = document.querySelector("#content");
            let readMoreText = document.querySelector("#readmore");
            contentInput.value = quill.root.innerHTML;
            // Update the hidden input field when content changes
            quill.on("text-change", function () {
                readMoreText.value = quill.getText();
                contentInput.value = quill.root.innerHTML;
            });
        });
    </script>

</x-layout>
