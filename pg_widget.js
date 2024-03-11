const cloudName = "dmmf2gbut"; 
const myGallery = cloudinary.galleryWidget({
  container: "#my-gallery",
  cloudName: cloudName,
  mediaAssets: [
    { tag: "Dental-Images" }, // by default mediaType: "image"
  ],
  // displayProps: { mode: "expanded", columns: 2 }, // multi column display
  // aspectRatio: "4:3", // if most assets are in landscape orientation
  // imageBreakpoint: 200,  // responsive resize images to closest step in 200px increments
  // carouselStyle: "indicators", // displays thumbnails by default
  // indicatorProps: { color: "red" },   // only relevant if CarouselStyle is set to indicators
  // carouselLocation: "right",  // "left" by default
  // borderColor: "red",  // color is transparent by default
  // borderWidth: 5, // border width is 0 by default
  // transition: "fade",  // "slide" by default
  // zoom: false,    // deactivate the zoom feature
});

myGallery.render();