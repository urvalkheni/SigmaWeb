# Pincode Lookup with Auto-fill

## Overview
An address form that automatically fills city and state fields when a valid pincode is entered, using JavaScript object lookup.

## Features
- **Auto-fill Functionality**: Automatically populates city and state
- **3 Test Pincodes**: Pre-configured pincode database
- **Real-time Lookup**: Checks pincode as you type (6 digits)
- **Error Handling**: Shows alert for invalid pincodes
- **Visual Feedback**: Green highlighting for auto-filled fields
- **Form Submission**: Complete form with validation

## Available Test Pincodes

### 400001 - Mumbai, Maharashtra
- **City**: Mumbai
- **State**: Maharashtra  
- **Region**: Western India

### 110001 - Delhi, Delhi
- **City**: Delhi
- **State**: Delhi
- **Region**: Northern India (Capital)

### 560001 - Bangalore, Karnataka
- **City**: Bangalore
- **State**: Karnataka
- **Region**: Southern India (Tech Hub)

## JavaScript Implementation

### Pincode Database
```javascript
const pincodeData = {
    "400001": {
        city: "Mumbai",
        state: "Maharashtra"
    },
    "110001": {
        city: "Delhi", 
        state: "Delhi"
    },
    "560001": {
        city: "Bangalore",
        state: "Karnataka"
    }
};
```

### Lookup Function
```javascript
function lookupPincode() {
    // Get pincode input (6 digits)
    // Check against database
    // Auto-fill city and state
    // Handle not found cases
    // Update visual styling
}
```

### Event Handling
- **Input Event**: `oninput="lookupPincode()"` 
- **Real-time**: Checks as you type
- **6-Digit Trigger**: Only looks up when exactly 6 digits entered

## User Experience Features

### Visual Feedback
- **Auto-filled Fields**: Green background (`#e8f5e8`)
- **Green Border**: Indicates successful lookup
- **Error State**: Red border for invalid pincode
- **Readonly Mode**: Auto-filled fields become readonly

### Error Handling
- **Invalid Pincode**: Shows JavaScript alert
- **Manual Entry**: Allows manual city/state entry if not found
- **Clear Reset**: Clears fields when pincode changes

### Form Validation
- **All Fields Required**: Validates before submission
- **6-Digit Pincode**: Ensures proper pincode format
- **Success Message**: Shows formatted address on submit

## CSS Features

### Styling States
```css
.auto-filled {
    background-color: #e8f5e8;
    border-color: #27ae60;
}

.error {
    border-color: #e74c3c;
}
```

### Info Box
- **Test Data Display**: Shows available pincodes
- **Blue Theme**: Helpful information styling
- **Clear Instructions**: User guidance

### Responsive Design
- **Mobile Friendly**: Works on all devices
- **Touch Compatible**: Large input fields
- **Readable Layout**: Clear form structure

## How to Use

### Step 1: Enter Pincode
1. Open `index.html` in browser
2. Click on pincode field
3. Type a 6-digit pincode

### Step 2: Auto-fill
- **Valid Pincode**: City and state auto-fill with green highlighting
- **Invalid Pincode**: Alert shows "Pincode not found"

### Step 3: Submit Form
1. Verify auto-filled information
2. Click "Submit Form" button
3. See success message with formatted address

### Testing Pincodes
- Try: `400001` (Mumbai)
- Try: `110001` (Delhi)  
- Try: `560001` (Bangalore)
- Try: `123456` (Invalid - shows alert)

## Technologies Used
- **HTML**: Form structure with proper labels
- **CSS**: Visual states and responsive design
- **JavaScript**: Object lookup and DOM manipulation

## File Structure
```
que_6/
├── index.html (Complete project with HTML, CSS, and JS)
└── README.md (This file)
```

## JavaScript Concepts Demonstrated

### Object Lookup
```javascript
if (pincodeData[pincode]) {
    // Pincode exists in database
    const location = pincodeData[pincode];
}
```

### DOM Manipulation
- **Element Selection**: `getElementById()`
- **Value Setting**: `element.value = newValue`
- **Class Management**: `classList.add()`, `classList.remove()`
- **Attribute Control**: `setAttribute()`, `removeAttribute()`

### Event Handling
- **Input Events**: Real-time text input monitoring
- **Form Submission**: `addEventListener('submit')`
- **Validation**: Prevent submission with invalid data

## Error Scenarios Handled

### Invalid Pincode
- **Action**: Shows alert message
- **Recovery**: Allows manual entry
- **Visual**: Error styling on pincode field

### Incomplete Form
- **Action**: Shows validation message  
- **Prevention**: Blocks form submission
- **Guidance**: Clear error messages

### Empty Fields
- **Action**: Highlights required fields
- **Message**: "Please fill all fields"
- **User Flow**: Guides to completion

## Key Learning Points
- **Object Data Storage**: Using JavaScript objects as database
- **Conditional Logic**: if-else for data validation
- **DOM Updates**: Real-time field updates
- **Form Handling**: Complete form submission flow
- **User Experience**: Helpful error messages and visual feedback

## Browser Compatibility
- All modern browsers
- IE9+ (basic JavaScript object support)
- Mobile browsers with touch support

## Future Enhancements
- **More Pincodes**: Expand database with more locations
- **API Integration**: Connect to real pincode API service
- **Autocomplete**: Add pincode suggestions
- **Validation**: Add pincode format validation
- **History**: Remember recently used pincodes

## Alternative Implementation Methods

### Method 1: onBlur Event
```javascript
// Checks only when user leaves pincode field
// Less real-time but fewer API calls
```

### Method 2: Button Trigger
```javascript
// Separate "Lookup" button
// User-controlled lookup timing
```

## Customization Options
- **Add Pincodes**: Extend the `pincodeData` object
- **Change Styling**: Modify auto-fill colors
- **Add Validation**: Include more form validation rules
- **API Integration**: Replace object with API calls