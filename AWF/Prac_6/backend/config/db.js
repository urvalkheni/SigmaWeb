const mongoose = require("mongoose");

async function connectDB() {
  try {
    const { MONGO_URI } = process.env;

    if (!MONGO_URI) {
      throw new Error("MONGO_URI is missing. Add it to the .env file.");
    }

    const connection = await mongoose.connect(MONGO_URI);
    console.log(`MongoDB connected successfully: ${connection.connection.host}`);
    return connection;
  } catch (error) {
    console.error("MongoDB connection failed:", error.message);
    throw error;
  }
}

module.exports = connectDB;
