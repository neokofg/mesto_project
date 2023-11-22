import {
  PerspectiveCamera,
  Environment,
  OrbitControls,
} from "@react-three/drei";
import { Canvas } from "@react-three/fiber";

const CabinetEnv = () => {
  const path = "/panorama/";
  const format = ".png";
  const photos = [
    path + "px" + format,
    path + "nx" + format,
    path + "py" + format,
    path + "ny" + format,
    path + "pz" + format,
    path + "nz" + format,
  ];
  return <Environment files={photos} background />;
};

const SinglePanorama = () => {
  return (
    <Canvas camera={{ position: [100, 1, 1] }}>
      <CabinetEnv />
      <OrbitControls makeDefault target={[0, 1, 0]} />
      <PerspectiveCamera fov={90} position={[-4, 4, 4]} makeDefault />
    </Canvas>
  );
};

export default SinglePanorama;
