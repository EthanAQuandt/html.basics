const exampleObject = {
    // Primitive types
    stringProperty: "Hello, world!",   // String
    numberProperty: 42,               // Number
    booleanProperty: true,            // Boolean
    nullProperty: null,               // Null
    undefinedProperty: undefined,     // Undefined
    bigIntProperty: 9007199254740991n, // BigInt
    symbolProperty: Symbol("unique"), // Symbol
  
    // Reference types
    arrayProperty: [1, 2, 3, 4],       // Array
    objectProperty: {                 // Object
      nestedString: "Nested value",
      nestedNumber: 99,
    },
    functionProperty: function () {    // Function
      return "I am a function!";
    },
    arrowFunctionProperty: () => "I am an arrow function!",
  
    // Date
    dateProperty: new Date(),          // Date
  
    // Regular expression
    regexProperty: /[A-Z]+/g,          // RegExp
  
    // Map and Set
    mapProperty: new Map([["key", "value"]]),  // Map
    setProperty: new Set([1, 2, 3]),           // Set
  
    // Typed arrays
    typedArrayProperty: new Int32Array([1, 2, 3]), // Typed array
  
    // WeakMap and WeakSet
    weakMapProperty: new WeakMap([[{}, "value"]]), // WeakMap
    weakSetProperty: new WeakSet([{}]),           // WeakSet
  
    // Promise
    promiseProperty: new Promise((resolve) => resolve("Promise resolved!")), // Promise
  
    // Class instance
    classInstanceProperty: new (class {
      constructor() {
        this.greeting = "Hello from the class!";
      }
    })(),
  
    // Error
    errorProperty: new Error("Something went wrong!"), // Error
  
    // Custom symbol key
    [Symbol("customSymbol")]: "I am a custom symbol property!",
  
    // Dynamic property
    [`dynamicProperty_${Math.random()}`]: "Dynamic value", // Dynamic key name
  };
  
  console.log(exampleObject);
  