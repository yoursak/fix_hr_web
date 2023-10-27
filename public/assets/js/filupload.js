/******/ (() => {
  // webpackBootstrap
  var __webpack_exports__ = {};

  $(".dropify").dropify({
    messages: {
      default: "Upload Your Business Profile",
      replace: "Drag and drop or click to replace",
      remove: "Remove",
      error: "Ooops, something wrong appended.",
    },
    error: {
      fileSize: "The file size is too big (2M max).",
    },
  });
  /******/
  
})();

function LoaderPackageDropify(id,content) {
  console.log(id);
  $('.'+id.toString()).dropify({
    messages: {
      default: content,
      replace: "Drag and drop or click to replace",
      remove: "Remove",
      error: "Ooops, something wrong appended.",
    },
    error: {
      fileSize: "The file size is too big (2M max).",
    },
  });
}
