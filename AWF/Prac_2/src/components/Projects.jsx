import React from 'react';

const Projects = () => {
  const projectsList = [
    { id: 1, title: 'E-commerce Platform', description: 'A full-stack online store with payment integration.' },
    { id: 2, title: 'Weather Dashboard', description: 'A dynamic weather app fetching real-time data from an API.' },
    { id: 3, title: 'Portfolio Website', description: 'A personal portfolio to showcase my projects and skills.' },
  ];

  return (
    <section className="glass-panel animate-fade-in">
      <h2 className="section-title">My Projects</h2>
      <div className="projects-grid">
        {projectsList.map((project) => (
          <div key={project.id} className="project-card" style={{ padding: '1.5rem', background: 'rgba(0,0,0,0.2)', borderRadius: '12px' }}>
            <h3>{project.title}</h3>
            <p style={{ color: '#cbd5e1' }}>{project.description}</p>
          </div>
        ))}
      </div>
    </section>
  );
};

export default Projects;
