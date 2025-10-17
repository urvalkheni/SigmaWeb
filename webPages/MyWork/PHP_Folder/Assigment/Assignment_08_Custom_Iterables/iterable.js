/**
 * Custom Iterable Objects - Advanced JavaScript Implementation
 * Student: Kheni Urval (24CE055)
 * Assignment 08: Custom Iterable Objects
 * Course: WDF: ITUE203
 * Medium-Level Implementation
 */

/**
 * Range Class - Custom Iterable for Number Ranges
 * Demonstrates Symbol.iterator implementation for for...of loops
 */
class Range {
    constructor(start, end, step = 1) {
        this.start = start;
        this.end = end;
        this.step = step;
        console.log(`Range created: ${start} to ${end} (step: ${step}) by Kheni Urval (24CE055)`);
    }

    /**
     * Symbol.iterator implementation for for...of loops
     */
    [Symbol.iterator]() {
        let current = this.start;
        const end = this.end;
        const step = this.step;

        return {
            next() {
                if ((step > 0 && current <= end) || (step < 0 && current >= end)) {
                    const value = current;
                    current += step;
                    return { value, done: false };
                }
                return { done: true };
            }
        };
    }

    /**
     * Convert range to array
     */
    toArray() {
        return [...this];
    }

    /**
     * Get range size
     */
    get size() {
        if (this.step > 0) {
            return Math.max(0, Math.floor((this.end - this.start) / this.step) + 1);
        } else {
            return Math.max(0, Math.floor((this.start - this.end) / Math.abs(this.step)) + 1);
        }
    }

    /**
     * Check if range contains a value
     */
    contains(value) {
        if (this.step > 0) {
            return value >= this.start && value <= this.end && (value - this.start) % this.step === 0;
        } else {
            return value <= this.start && value >= this.end && (this.start - value) % Math.abs(this.step) === 0;
        }
    }

    /**
     * Map function over range values
     */
    map(fn) {
        return [...this].map(fn);
    }

    /**
     * Filter range values
     */
    filter(fn) {
        return [...this].filter(fn);
    }

    /**
     * Reduce range values
     */
    reduce(fn, initial) {
        return [...this].reduce(fn, initial);
    }

    /**
     * String representation
     */
    toString() {
        return `Range(${this.start}, ${this.end}, ${this.step})`;
    }
}

/**
 * Collection Class - Custom Iterable Collection with Advanced Features
 */
class Collection {
    constructor(items = []) {
        this.items = [...items];
        this.name = 'Custom Collection';
        console.log(`Collection created with ${this.items.length} items by Kheni Urval (24CE055)`);
    }

    /**
     * Symbol.iterator implementation
     */
    [Symbol.iterator]() {
        let index = 0;
        const items = this.items;

        return {
            next() {
                if (index < items.length) {
                    return { value: items[index++], done: false };
                }
                return { done: true };
            }
        };
    }

    /**
     * Add item to collection
     */
    add(item) {
        this.items.push(item);
        return this;
    }

    /**
     * Remove item from collection
     */
    remove(item) {
        const index = this.items.indexOf(item);
        if (index > -1) {
            this.items.splice(index, 1);
        }
        return this;
    }

    /**
     * Get collection size
     */
    get size() {
        return this.items.length;
    }

    /**
     * Check if collection is empty
     */
    get isEmpty() {
        return this.items.length === 0;
    }

    /**
     * Clear all items
     */
    clear() {
        this.items = [];
        return this;
    }

    /**
     * Check if collection contains item
     */
    contains(item) {
        return this.items.includes(item);
    }

    /**
     * Convert to array
     */
    toArray() {
        return [...this.items];
    }

    /**
     * Find item by predicate
     */
    find(predicate) {
        return this.items.find(predicate);
    }

    /**
     * Filter items
     */
    filter(predicate) {
        return new Collection(this.items.filter(predicate));
    }

    /**
     * Map items
     */
    map(mapper) {
        return new Collection(this.items.map(mapper));
    }

    /**
     * Reduce items
     */
    reduce(reducer, initial) {
        return this.items.reduce(reducer, initial);
    }

    /**
     * For each iteration
     */
    forEach(callback) {
        this.items.forEach(callback);
        return this;
    }

    /**
     * Get first item
     */
    first() {
        return this.items[0];
    }

    /**
     * Get last item
     */
    last() {
        return this.items[this.items.length - 1];
    }

    /**
     * String representation
     */
    toString() {
        return `Collection[${this.items.join(', ')}]`;
    }
}

/**
 * Matrix Class - 2D Iterable Matrix Implementation
 */
class Matrix {
    constructor(rows, cols, initialValue = 0) {
        this.rows = rows;
        this.cols = cols;
        this.data = Array(rows).fill().map(() => Array(cols).fill(initialValue));
        console.log(`Matrix created (${rows}x${cols}) by Kheni Urval (24CE055)`);
    }

    /**
     * Symbol.iterator implementation - iterates row by row
     */
    [Symbol.iterator]() {
        let rowIndex = 0;
        let colIndex = 0;
        const matrix = this;

        return {
            next() {
                if (rowIndex < matrix.rows) {
                    const value = matrix.data[rowIndex][colIndex];
                    colIndex++;
                    
                    if (colIndex >= matrix.cols) {
                        colIndex = 0;
                        rowIndex++;
                    }
                    
                    return { value, done: false };
                }
                return { done: true };
            }
        };
    }

    /**
     * Get value at position
     */
    get(row, col) {
        if (row >= 0 && row < this.rows && col >= 0 && col < this.cols) {
            return this.data[row][col];
        }
        throw new Error(`Index out of bounds: (${row}, ${col})`);
    }

    /**
     * Set value at position
     */
    set(row, col, value) {
        if (row >= 0 && row < this.rows && col >= 0 && col < this.cols) {
            this.data[row][col] = value;
        } else {
            throw new Error(`Index out of bounds: (${row}, ${col})`);
        }
        return this;
    }

    /**
     * Get row as array
     */
    getRow(rowIndex) {
        if (rowIndex >= 0 && rowIndex < this.rows) {
            return [...this.data[rowIndex]];
        }
        throw new Error(`Row index out of bounds: ${rowIndex}`);
    }

    /**
     * Get column as array
     */
    getCol(colIndex) {
        if (colIndex >= 0 && colIndex < this.cols) {
            return this.data.map(row => row[colIndex]);
        }
        throw new Error(`Column index out of bounds: ${colIndex}`);
    }

    /**
     * Fill matrix with value
     */
    fill(value) {
        for (let i = 0; i < this.rows; i++) {
            for (let j = 0; j < this.cols; j++) {
                this.data[i][j] = value;
            }
        }
        return this;
    }

    /**
     * Map function over all elements
     */
    map(fn) {
        const result = new Matrix(this.rows, this.cols);
        for (let i = 0; i < this.rows; i++) {
            for (let j = 0; j < this.cols; j++) {
                result.data[i][j] = fn(this.data[i][j], i, j);
            }
        }
        return result;
    }

    /**
     * Convert to flat array
     */
    toArray() {
        return [...this];
    }

    /**
     * Convert to 2D array
     */
    to2DArray() {
        return this.data.map(row => [...row]);
    }

    /**
     * String representation
     */
    toString() {
        return this.data.map(row => row.join('\t')).join('\n');
    }
}

/**
 * Fibonacci Sequence - Infinite Iterable Implementation
 */
class FibonacciSequence {
    constructor(limit = Infinity) {
        this.limit = limit;
        console.log(`Fibonacci sequence created (limit: ${limit}) by Kheni Urval (24CE055)`);
    }

    /**
     * Symbol.iterator implementation for infinite or limited Fibonacci sequence
     */
    [Symbol.iterator]() {
        let count = 0;
        let a = 0;
        let b = 1;
        const limit = this.limit;

        return {
            next() {
                if (count < limit) {
                    count++;
                    if (count === 1) {
                        return { value: a, done: false };
                    } else if (count === 2) {
                        return { value: b, done: false };
                    } else {
                        const next = a + b;
                        a = b;
                        b = next;
                        return { value: next, done: false };
                    }
                }
                return { done: true };
            }
        };
    }

    /**
     * Take first n numbers
     */
    take(n) {
        return new FibonacciSequence(n);
    }

    /**
     * Convert to array (limited)
     */
    toArray() {
        if (this.limit === Infinity) {
            throw new Error('Cannot convert infinite sequence to array. Use take(n) first.');
        }
        return [...this];
    }

    /**
     * String representation
     */
    toString() {
        if (this.limit === Infinity) {
            return 'FibonacciSequence(∞)';
        }
        return `FibonacciSequence(${this.limit})`;
    }
}

/**
 * Tree Node for Tree Iteration
 */
class TreeNode {
    constructor(value) {
        this.value = value;
        this.children = [];
    }

    addChild(child) {
        this.children.push(child);
        return this;
    }
}

/**
 * Tree Class - Depth-First Iterable Tree
 */
class Tree {
    constructor(rootValue) {
        this.root = new TreeNode(rootValue);
        console.log(`Tree created with root: ${rootValue} by Kheni Urval (24CE055)`);
    }

    /**
     * Symbol.iterator implementation - depth-first traversal
     */
    [Symbol.iterator]() {
        const stack = [this.root];

        return {
            next() {
                if (stack.length > 0) {
                    const node = stack.pop();
                    
                    // Add children to stack in reverse order for correct depth-first order
                    for (let i = node.children.length - 1; i >= 0; i--) {
                        stack.push(node.children[i]);
                    }
                    
                    return { value: node.value, done: false };
                }
                return { done: true };
            }
        };
    }

    /**
     * Add child to root
     */
    addChild(value) {
        this.root.addChild(new TreeNode(value));
        return this;
    }

    /**
     * Breadth-first iterator
     */
    *breadthFirst() {
        const queue = [this.root];
        
        while (queue.length > 0) {
            const node = queue.shift();
            yield node.value;
            
            for (const child of node.children) {
                queue.push(child);
            }
        }
    }

    /**
     * Convert to array
     */
    toArray() {
        return [...this];
    }

    /**
     * String representation
     */
    toString() {
        return `Tree[${this.toArray().join(', ')}]`;
    }
}

/**
 * Utility Functions for Custom Iterables
 */
class IterableUtils {
    /**
     * Create range (static factory method)
     */
    static range(start, end, step = 1) {
        return new Range(start, end, step);
    }

    /**
     * Take first n items from any iterable
     */
    static take(iterable, n) {
        const result = [];
        let count = 0;
        
        for (const item of iterable) {
            if (count >= n) break;
            result.push(item);
            count++;
        }
        
        return result;
    }

    /**
     * Skip first n items from any iterable
     */
    static skip(iterable, n) {
        const result = [];
        let count = 0;
        
        for (const item of iterable) {
            if (count >= n) {
                result.push(item);
            }
            count++;
        }
        
        return result;
    }

    /**
     * Chain multiple iterables
     */
    static chain(...iterables) {
        return {
            *[Symbol.iterator]() {
                for (const iterable of iterables) {
                    for (const item of iterable) {
                        yield item;
                    }
                }
            }
        };
    }

    /**
     * Zip multiple iterables together
     */
    static zip(...iterables) {
        return {
            *[Symbol.iterator]() {
                const iterators = iterables.map(it => it[Symbol.iterator]());
                
                while (true) {
                    const results = iterators.map(it => it.next());
                    
                    if (results.some(result => result.done)) {
                        break;
                    }
                    
                    yield results.map(result => result.value);
                }
            }
        };
    }

    /**
     * Enumerate iterable with indices
     */
    static enumerate(iterable) {
        return {
            *[Symbol.iterator]() {
                let index = 0;
                for (const item of iterable) {
                    yield [index++, item];
                }
            }
        };
    }

    /**
     * Convert any iterable to array
     */
    static toArray(iterable) {
        return [...iterable];
    }

    /**
     * Count items in iterable
     */
    static count(iterable) {
        let count = 0;
        for (const item of iterable) {
            count++;
        }
        return count;
    }

    /**
     * Check if all items satisfy condition
     */
    static all(iterable, predicate) {
        for (const item of iterable) {
            if (!predicate(item)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Check if any item satisfies condition
     */
    static any(iterable, predicate) {
        for (const item of iterable) {
            if (predicate(item)) {
                return true;
            }
        }
        return false;
    }
}

// Export for Node.js if needed
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        Range,
        Collection,
        Matrix,
        FibonacciSequence,
        Tree,
        TreeNode,
        IterableUtils
    };
}

// Global assignment for browser
if (typeof window !== 'undefined') {
    window.CustomIterables = {
        Range,
        Collection,
        Matrix,
        FibonacciSequence,
        Tree,
        TreeNode,
        IterableUtils
    };
}

console.log('Custom Iterable Objects library loaded by Kheni Urval (24CE055)');
