// Utility functions for reading and writing to local storage

/**
 * Save a value to local storage
 * @param {string} key - The key under which the value will be stored
 * @param {*} value - The value to store (will be stringified)
 */
function saveToLocalStorage(key, value) {
  if (!key || typeof key !== "string") {
    console.error("Key must be a non-empty string");
    return;
  }
  try {
    const serializedValue = JSON.stringify(value);
    localStorage.setItem(key, serializedValue);
  } catch (error) {
    console.error("Failed to save to local storage:", error);
  }
}

/**
 * Retrieve a value from local storage
 * @param {string} key - The key of the value to retrieve
 * @returns {*} - The parsed value, or null if not found
 */
function getFromLocalStorage(key) {
  if (!key || typeof key !== "string") {
    console.error("Key must be a non-empty string");
    return null;
  }
  try {
    const serializedValue = localStorage.getItem(key);
    return serializedValue ? JSON.parse(serializedValue) : null;
  } catch (error) {
    console.error("Failed to retrieve from local storage:", error);
    return null;
  }
}

/**
 * Retrieve an object from local storage
 * @param {string} key - The key of the object to retrieve
 * @returns {object|null} - The parsed object, or null if not found or invalid
 */
function getObjectFromLocalStorage(key) {
  const value = getFromLocalStorage(key);
  if (value && typeof value === "object" && !Array.isArray(value)) {
    return value;
  }
  console.error("Value is not a valid object or does not exist");
  return null;
}

/**
 * Remove a value from local storage
 * @param {string} key - The key of the value to remove
 */
function removeFromLocalStorage(key) {
  if (!key || typeof key !== "string") {
    console.error("Key must be a non-empty string");
    return;
  }
  try {
    localStorage.removeItem(key);
  } catch (error) {
    console.error("Failed to remove from local storage:", error);
  }
}

/**
 * Clear all data from local storage
 */
function clearLocalStorage() {
  try {
    localStorage.clear();
  } catch (error) {
    console.error("Failed to clear local storage:", error);
  }
}

// Example usage:
//saveToLocalStorage('username', 'Ethan');
//console.log(getFromLocalStorage('username')); // Outputs: 'Ethan'
saveToLocalStorage("user", { name: "Ethan", age: 25 });
console.log(getObjectFromLocalStorage("user")); // Outputs: { name: 'Ethan', age: 25 }
// removeFromLocalStorage('username');
// clearLocalStorage();
