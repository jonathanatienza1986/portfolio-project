<template>
    <!-- Scrolling Ticker -->
    <div class=" overflow-hidden cursor-pointer p-0 m-0 z-10">
      <div class=" flex w-max ticker-content">
        <!-- Duplicate this block for seamless effect -->
        <div class="ticker-item">• Hi, I’m Garry — a Full Stack Developer</div>
        <div class="ticker-item">• I build scalable web apps, dashboards, and AI-powered systems.</div>
        <div class="ticker-item">• Contact me: 09995202447</div>
        <div class="ticker-item">• Email me: gc120978levelup1@gmail.com</div>
        <div class="ticker-item">• Let me build a scalable and productive web application for you.</div>

        <div class="ticker-item">• Hi, I’m Garry — a Full Stack Developer</div>
        <div class="ticker-item">• I build scalable web apps, dashboards, and AI-powered systems.</div>
        <div class="ticker-item">• Contact me: 09995202447</div>
        <div class="ticker-item">• Email me: gc120978levelup1@gmail.com</div>
        <div class="ticker-item">• Let me build a scalable and productive web application for you.</div>

        <div class="ticker-item">• Hi, I’m Garry — a Full Stack Developer</div>
        <div class="ticker-item">• I build scalable web apps, dashboards, and AI-powered systems.</div>
        <div class="ticker-item">• Contact me: 09995202447</div>
        <div class="ticker-item">• Email me: gc120978levelup1@gmail.com</div>
        <div class="ticker-item">• Let me build a scalable and productive web application for you.</div>

        <div class="ticker-item">• Hi, I’m Garry — a Full Stack Developer</div>
        <div class="ticker-item">• I build scalable web apps, dashboards, and AI-powered systems.</div>
        <div class="ticker-item">• Contact me: 09995202447</div>
        <div class="ticker-item">• Email me: gc120978levelup1@gmail.com</div>
        <div class="ticker-item">• Let me build a scalable and productive web application for you.</div>
      </div>
    </div>
  </template>

  <style scoped>
  .ticker-content {
    animation: scrollLeft 30s linear infinite;
  }

  .ticker-content:hover {
    animation-play-state: paused;
  }

  @keyframes scrollLeft {
    from {
      transform: translateX(0);
    }

    to {
      /* Moves the entire set by half its total width */
      transform: translateX(-50%);
    }
  }

  .ticker-item {
    padding: 2px;
    white-space: nowrap;
  }
  </style>
