import { useState, useEffect } from 'react';
import NavBar from './components/NavBar';
import Header from './components/Header';
import About from './components/About';
import Experience from './components/Experience';
import Contributions from './components/Contributions';
import Projects from './components/Projects';
import Skills from './components/Skills';
import Certifications from './components/Certifications';
import Contact from './components/Contact';
import Footer from './components/Footer';
import './index.css';

function App() {
  const [themeMode, setThemeMode] = useState('dark');

  useEffect(() => {
    if (themeMode === 'light') {
      document.documentElement.style.setProperty('--bg-color', '#f8fafc');
      document.documentElement.style.setProperty('--text-color', '#0f172a');
      document.documentElement.style.setProperty('--card-bg', 'rgba(255, 255, 255, 0.7)');
      document.documentElement.style.setProperty('--border-color', 'rgba(0, 0, 0, 0.1)');
    } else {
      document.documentElement.style.setProperty('--bg-color', '#0f172a');
      document.documentElement.style.setProperty('--text-color', '#f8fafc');
      document.documentElement.style.setProperty('--card-bg', 'rgba(30, 41, 59, 0.7)');
      document.documentElement.style.setProperty('--border-color', 'rgba(255, 255, 255, 0.1)');
    }
  }, [themeMode]);

  const toggleTheme = () => {
    setThemeMode((prev) => (prev === 'dark' ? 'light' : 'dark'));
  };

  return (
    <>
      <NavBar themeMode={themeMode} toggleTheme={toggleTheme} />
      
      <main>
        <Header />
        <About />
        <Experience />
        <Contributions />
        <Projects />
        <Skills />
        <Certifications />
        <Contact />
      </main>

      <Footer />
    </>
  );
}

export default App;
