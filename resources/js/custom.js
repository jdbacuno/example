// dismissing alert
// target element that will be dismissed
const $targetEl = document.getElementById("targetElement");

// optional trigger element
const $triggerEl = document.getElementById("triggerElement");

// options object
const options = {
    transition: "transition-opacity",
    duration: 1000,
    timing: "ease-out",

    // callback functions
    onHide: (context, targetEl) => {
        console.log("element has been dismissed");
        console.log(targetEl);
    },
};

// instance options object
const instanceOptions = {
    id: "targetElement",
    override: true,
};
