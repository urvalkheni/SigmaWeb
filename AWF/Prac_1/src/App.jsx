import { useState } from 'react';
import Header from './components/Header';
import NavBar from './components/NavBar';
import About from './components/About';
import Skills from './components/Skills';
import Projects from './components/Projects';
import Footer from './components/Footer';
import './index.css';

function App() {
  const [activeTab, setActiveTab] = useState('About');
  
  const mySkills = ['JavaScript', 'React', 'Node.js', 'CSS3', 'HTML5', 'Git', 'Python'];

  return (
    <>
      <Header name="Urval Kheni" themeColor="#38bdf8" />
      <NavBar activeTab={activeTab} setActiveTab={setActiveTab} />
      
      <main style={{ minHeight: '40vh' }}>
        {activeTab === 'About' && <About />}
        {activeTab === 'Skills' && <Skills skillList={mySkills} />}
        {activeTab === 'Projects' && <Projects />}
      </main>

      <Footer />
    </>
  );
}

export default App;
