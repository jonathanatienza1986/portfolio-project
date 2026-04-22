<script setup>
import { onMounted, onBeforeUnmount, ref } from 'vue'
import * as THREE from 'three'

import { EffectComposer } from 'three/examples/jsm/postprocessing/EffectComposer.js'
import { RenderPass } from 'three/examples/jsm/postprocessing/RenderPass.js'
import { UnrealBloomPass } from 'three/examples/jsm/postprocessing/UnrealBloomPass.js'

const container = ref(null)

let scene, camera, renderer, composer, bloomPass, frameId

const scrollState = {
  current: 0,
  target: 0,
}

const mouse = {
  x: 0,
  y: 0,
  tx: 0,
  ty: 0,
}

const MAX_SECTIONS = 30
const WORLD_HEIGHT = MAX_SECTIONS * 6
const TOTAL_STARS = 8000

let time = 0

onMounted(() => {
  const width = window.innerWidth
  const height = window.innerHeight

  // SCENE
  scene = new THREE.Scene()
  scene.background = new THREE.Color(0x050505)
  scene.fog = new THREE.Fog(0x0a0a0a, 4, WORLD_HEIGHT)

  // CAMERA
  camera = new THREE.PerspectiveCamera(50, width / height, 0.1, 1000)
  camera.position.set(0, 0, 0)

  // RENDERER
  renderer = new THREE.WebGLRenderer({
    antialias: true,
    powerPreference: "high-performance",
  })

  renderer.setSize(width, height)
  renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2))
  container.value.appendChild(renderer.domElement)

  // LIGHTS
  scene.add(new THREE.AmbientLight(0x2fffff, 1.25))

  const light = new THREE.PointLight(0xff6fff, 2.4)
  light.position.set(5, 5, 5)
  scene.add(light)

  // STARFIELD
  const objects = []

  const geometry = new THREE.IcosahedronGeometry(0.03, 0)

  const material = new THREE.MeshStandardMaterial({
    color: new THREE.Color(0x66e6ff),
    emissive: new THREE.Color(0x66e6ff),
    emissiveIntensity: 0.9,
    roughness: 1.25,
    metalness: 1.7,
  })

  for (let i = 0; i < TOTAL_STARS; i++) {
    const mesh = new THREE.Mesh(geometry, material)

    mesh.position.set(
      (Math.random() - 0.5) * 24,
      (Math.random() - 0.5) * WORLD_HEIGHT,
      (Math.random() - 0.5) * 24
    )

    mesh.userData.basePos = mesh.position.clone()
    mesh.userData.baseScale = 0.2 + Math.random() * 0.8
    mesh.userData.seed = Math.random() * 1000

    scene.add(mesh)
    objects.push(mesh)
  }

  // BLOOM
  composer = new EffectComposer(renderer)
  composer.addPass(new RenderPass(scene, camera))

  bloomPass = new UnrealBloomPass(
    new THREE.Vector2(width, height),
    2.0,
    2.0,
    0.9
  )

  composer.addPass(bloomPass)

  // SCROLL
  const el = document.querySelector('.story')

  el.addEventListener('scroll', () => {
    const max = el.scrollHeight - el.clientHeight
    scrollState.target = Math.min(1, Math.max(0, el.scrollTop / max))
  })

  // MOUSE
  window.addEventListener('mousemove', (e) => {
    mouse.tx = (e.clientX / window.innerWidth - 0.5) * 2
    mouse.ty = (-e.clientY / window.innerHeight - 0.5) * 2
  })

  const onResize = () => {
    camera.aspect = window.innerWidth / window.innerHeight
    camera.updateProjectionMatrix()

    renderer.setSize(window.innerWidth, window.innerHeight)
    composer.setSize(window.innerWidth, window.innerHeight)
  }

  window.addEventListener('resize', onResize)

  // COLORS (8 SECTIONS)
  const colors = [
    0x66e6ff,
    0x3b82f6,
    0xa855f7,
    0x66e6ff,
    0xfbbf24,
    0x22c55e,
    0xf97316,
    0x18fafc,
    0x66e6ff,
    0x3b82f6,
    0xa855f7,
    0x66e6ff,
    0xfbbf24,
    0x22c55e,
    0xf97316,
    0x18fafc
  ]

  const color = new THREE.Color()

  const animate = () => {
    frameId = requestAnimationFrame(animate)

    time += 0.003

    scrollState.current +=
      (scrollState.target - scrollState.current) * 0.06

    const t = scrollState.current

    // smooth mouse
    mouse.x += (mouse.tx - mouse.x) * 0.05
    mouse.y += (mouse.ty - mouse.y) * 0.05

    // CAMERA
    const cameraEndY = -WORLD_HEIGHT * 0.35

    camera.position.x = mouse.x * 1.8
    camera.position.y =
      THREE.MathUtils.lerp(0, cameraEndY, t) + mouse.y * 1.5

    camera.position.z = THREE.MathUtils.lerp(6, 7, t)

    camera.rotation.y = mouse.x * 0.4
    camera.rotation.x = mouse.y * 0.2

    // =====================
    // SECTION INDEX
    // =====================
    const sectionIndex = Math.floor(t * MAX_SECTIONS)

    const isFinalSection = sectionIndex === MAX_SECTIONS - 1000

    // =====================
    // COLOR SYSTEM (DISABLE IN FINAL SECTION)
    // =====================
    if (!isFinalSection) {
      const scaled = t * (colors.length - 1)
      const i = Math.floor(scaled)
      const lt = scaled - i

      const c1 = new THREE.Color(colors[i])
      const c2 = new THREE.Color(colors[i + 1] || colors[i])

      color.copy(c1).lerp(c2, lt)

      material.color = color
      material.emissive = color

      bloomPass.strength = 1.5 + t * 1.5
      bloomPass.radius = 1.0
      bloomPass.threshold = 0.2
    }

    // =====================
    // STARS
    // =====================
    objects.forEach((obj) => {
      const base = obj.userData.basePos
      const s = obj.userData.seed

      obj.rotation.y += 0.0045
      obj.rotation.x += 0.001

      obj.position.x =
        base.x + mouse.x * 0.5 + Math.sin(time + s) * 0.7

      obj.position.y =
        base.y + mouse.y * 0.3 + Math.cos(time + s) * 0.28

      obj.position.z =
        base.z + Math.sin(time * 0.5 + s) * 0.05

      obj.scale.setScalar(obj.userData.baseScale * (1 + t * 0.1))
    })

    composer.render()
  }

  animate()

  onBeforeUnmount(() => {
    cancelAnimationFrame(frameId)
    window.removeEventListener('resize', onResize)
  })
})
</script>

<template>
  <div ref="container" class="scene"></div>
</template>

<style scoped>
.scene {
  position: fixed;
  top: 0;
  left: 0;
  inset: 0;
  z-index: 0;
}
</style>
